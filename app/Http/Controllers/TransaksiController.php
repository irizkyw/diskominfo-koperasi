<?php

namespace App\Http\Controllers;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\Tabungan;
use Yajra\DataTables\DataTables;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransaksiExport;
use App\Exports\TransaksiTemplate;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use App\Models\Golongan;


class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::orderBy("created_at", "desc")->get();
        $users = User::all();
        $roles = Role::all();

        return view(
            "dashboard.pages.transaksi",
            compact("transaksi", "users", "roles")
        );
    }

    public function datatable()
    {
        $query = Transaksi::get();

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn("simpanan_id", function ($row) {
                return $row->id;
            })
            ->addColumn("user_id", function ($row) {
                $name = $row->user->name;
                $golongan = $row->user->golongan->nama_golongan ?? "Error";
                return "{$name} ({$golongan})";
            })
            ->editColumn("transaction_type", function ($row) {
                return $row->transaction_type;
            })
            ->editColumn("description", function ($row) {
                return $row->description;
            })
            ->editColumn("date_transaction", function ($row) {
                return Carbon::parse($row->date_transaction)->translatedFormat(
                    "d F Y"
                );
            })
            ->editColumn("nominal", function ($row) {
                return "Rp" . number_format($row->nominal, 0, ",", ".");
            })
            ->addColumn("actions", function ($row) {
                return '
                <div class="d-flex justify-content-end">
                    <a href="#"
                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 transaksi-edit"
                        data-id="' .
                    $row->id .
                    '">
                        <span class="svg-icon svg-icon-2">
                            <i class="fas fa-pen"></i>
                        </span>
                    </a>
                    <a href="#"
                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 transaksi-delete"
                        data-id="' .
                    $row->id .
                    '">
                        <span class="svg-icon svg-icon-2">
                            <i class="fas fa-trash"></i>
                        </span>
                    </a>
                    <a href="' .
                    route("profile", ["user_id" => $row->user_id]) .
                    '"
                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                        <span class="svg-icon svg-icon-2">
                            <i class="fas fa-user"></i>
                        </span>
                    </a>
                </div>';
            })
            ->rawColumns(["actions"])
            ->make(true);
    }

    public function createSimpanan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => "required|exists:users,id",
            "transaction_type" => "required|string|max:255",
            "desc" => "required|string|max:255",
            "date_transaction" => "required|date",
            "nominal" => "required|numeric",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "errors" => $validator->errors(),
                ],
                422
            );
        }

        $transaksi = Transaksi::create([
            "user_id" => $request->user_id,
            "transaction_type" => $request->transaction_type,
            "description" => $request->desc,
            "date_transaction" => $request->date_transaction,
            "nominal" => $request->nominal,
        ]);


        $tabungan = Tabungan::where("user_id", $request->user_id)
                            ->whereYear("tabungan_tahun", $request->date_transaction)
                            ->first();


        if ($tabungan) {
            if ($request->transaction_type == "Simpanan Wajib") {
                $tabungan->simp_wajib += $request->nominal;
            }
            if ($request->transaction_type == "Simpanan Sukarela") {
                $tabungan->simp_sukarela += $request->nominal;
            }
            $tabungan->save();
        } else {
            $tabungan = Tabungan::create([
                "user_id" => $request->user_id,
                "simp_pokok" => User::find($request->user_id)->golongan->simp_pokok,
                "simp_wajib" =>
                    $request->transaction_type == "Simpanan Wajib"
                        ? $request->nominal
                        : 0,
                "simp_sukarela" =>
                    $request->transaction_type == "Simpanan Sukarela"
                        ? $request->nominal
                        : 0,
                        
                "tabungan_tahun" => Carbon::parse($request->date_transaction)->format("Y"),
            ]);
        }

        return response()->json(
            [
                "message" => "Transaksi telah ditambahkan",
                "transaksi" => $transaksi,
                "tabungan" => $tabungan,
            ],
            200
        );
    }

    public function updateSimpanan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "user_id" => "required|exists:users,id",
            "transaction_type" => "required|string|max:255",
            "desc" => "required|string|max:255",
            "date_transaction" => "required|date",
            "nominal" => "required|numeric",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "errors" => $validator->errors(),
                ],
                422
            );
        }

        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json(["message" => "Transaksi not found"], 404);
        }

        $oldTransactionType = $transaksi->transaction_type;
        $oldNominal = $transaksi->nominal;

        // Update the transaction
        $transaksi->update([
            "user_id" => $request->user_id,
            "transaction_type" => $request->transaction_type,
            "description" => $request->desc,
            "date_transaction" => $request->date_transaction,
            "nominal" => $request->nominal,
        ]);

        // Find the user's Tabungan record
        $tabungan = Tabungan::where("user_id", $request->user_id)->first();

        if ($tabungan) {
            // Adjust the tabungan values based on the new and old transaction types
            if ($oldTransactionType == "Simpanan Wajib") {
                $tabungan->simp_wajib -= $oldNominal; // Remove the old nominal
            } elseif ($oldTransactionType == "Simpanan Sukarela") {
                $tabungan->simp_sukarela -= $oldNominal; // Remove the old nominal
            }

            if ($request->transaction_type == "Simpanan Wajib") {
                $tabungan->simp_wajib += $request->nominal; // Add the new nominal
            } elseif ($request->transaction_type == "Simpanan Sukarela") {
                $tabungan->simp_sukarela += $request->nominal; // Add the new nominal
            }

            $tabungan->save();
        }

        return response()->json(
            [
                "message" => "Simpanan telah dirubah!",
                "transaksi" => $transaksi,
            ],
            200
        );
    }

    public function transaksiById($id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json(["message" => "Transaksi not found"], 404);
        }
        $data = [
            "id" => $transaksi->id,
            "user_id" => $transaksi->user_id,
            "name" => $transaksi->user->name,
            "transaction_type" => $transaksi->transaction_type,
            "nominal" => $transaksi->nominal,
            "date_transaction" => $transaksi->date_transaction,
            "description" => $transaksi->description,
        ];
        return response()->json($data);
    }

    public function LaporanByUserId($id)
    {
        $SimpananWajibLast = Tabungan::where("user_id", $id)->first()
            ->simp_pokok;
        $SimpananWajib = Transaksi::where("user_id", $id)
            ->where("transaction_type", "Simpanan Wajib")
            ->sum("nominal");
        $SimpananWajib = $SimpananWajibLast + $SimpananWajib;
        $SimpananWajib80 = $SimpananWajib * 0.8;

        $SimpananPokok = Tabungan::where("user_id", $id)->first()
            ->principal_savings;
        $SimpananSukarela = Tabungan::where("user_id", $id)->first()
            ->voluntary_savings;
        $SimpananAkhir = $SimpananWajib80 + $SimpananPokok + $SimpananSukarela;
        return response()->json([
            "SimpananWajibLast" => $SimpananWajibLast,
            "SimpananSukarela" => $SimpananSukarela,
            "SimpananPokok" => $SimpananPokok,
            "SimpananWajibNow" => $SimpananWajib,
            "SimpananWajib80" => $SimpananWajib80,
            "SimpananAkhir" => $SimpananAkhir,
        ]);
    }

    public function deleteSimpanan($id)
    {
        $simpanan = Transaksi::findOrFail($id);
        $transaction_type = $simpanan->transaction_type;
        $user_id = $simpanan->user_id;

        $simpanan->delete();

        $tabungan = Tabungan::where("user_id", $user_id)->first();

        if ($tabungan) {
            if ($transaction_type == "Simpanan Wajib") {
                $tabungan->simp_wajib -= $simpanan->nominal;
            } elseif ($transaction_type == "Simpanan Sukarela") {
                $tabungan->simp_sukarela -= $simpanan->nominal;
            }

            $tabungan->save();
        }

        return response()->json(["message" => "Simpanan deleted successfully"]);
    }

    public function exportTemplate(Request $request)
    {
        $tahun = $request->query("year", date("Y")); // Get the year from the query parameter or default to the current year

        $filename = "transactions_" . date("YmdHis") . ".xlsx";

        // Export data for the selected year
        return Excel::download(new TransaksiTemplate($tahun), $filename);
    }

    public function exportSimpanan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "format" => "required|in:xlsx,csv,pdf",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $query = Transaksi::orderBy("created_at", "desc");

        if ($request->has("filterAnggota") && $request->filterAnggota != "*") {
            $query->where("user_id", $request->filterAnggota);
        }

        if (
            $request->has("filterTipeTransaksi") &&
            $request->filterTipeTransaksi != "*"
        ) {
            $query->where("transaction_type", $request->filterTipeTransaksi);
        }

        if ($request->has("filterTahun")) {
            $query->whereYear("date_transaction", $request->filterTahun);
        }

        $tahun = null;

        if ($request->has("filterTahun") && $request->filterTahun != "*") {
            $tahun = $request->filterTahun;
        }

        $transactions = $query->get();

        $format = $request->format;

        $filename = "transactions_" . date("YmdHis") . "." . $format;

        // Ekspor data sesuai format yang dipilih
        return Excel::download(
            new TransaksiExport($transactions, $tahun),
            $filename
        );
    }

    public function importSimpanan(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            "file" => "required|file|mimes:xlsx,csv",
        ]);

        $tahun = $request->input("FilterTahunImport"); // Fetch the year from request

        $file = $request->file("file");

        // Import data
        Excel::import(
            new class ($tahun) implements ToCollection, WithHeadingRow {
                private $tahun;

                public function __construct($tahun)
                {
                    $this->tahun = $tahun;
                }

                public function collection(Collection $rows)
                {
                    foreach ($rows as $row) {
                        // Fetch the user based on 'No Anggota'
                        $user = User::where(
                            "num_member",
                            $row["no_anggota"]
                        )->first();

                        if (!$user) {
                            if (
                                $row["nama_user"] == null ||
                                $row["no_anggota"] == null
                            ) {
                                continue;
                            }
                            $generateUniqueUsername = function ($name, $num_member) {
                                do {
                                    $words = explode(" ", $name);
                                    $firstName = strtolower($words[0]);
                                    $username =
                                        $firstName . str_pad($num_member, 3, "0", STR_PAD_LEFT);
                                    $userExists = User::where("username", $username)->exists();
                                } while ($userExists);
                    
                                return $username;
                            };
                            $username = $generateUniqueUsername(
                                $row["nama_user"],
                                $row["no_anggota"]
                            );
                            $user = User::create([
                                "num_member" => $row["no_anggota"],
                                "name" => $row["nama_user"],
                                "role_id" => 2,
                                "status_active" => 1,
                                "golongan_id" => Golongan::where('simp_pokok', $row["simpanan_pokok"])->first()->id ?? 2,
                                "username" =>$username,
                                "password" => Hash::make($username),
                            ]);

                            // Update or create Tabungan record Tahun Lalu
                            Tabungan::updateOrCreate(
                                [   "user_id" => $user->id,
                                    "tabungan_tahun" => $this->tahun-1,
                                ],
                                [
                                    "simp_pokok" => $row["simpanan_pokok"] ?? 0,
                                    "simp_sukarela" =>
                                        $row["simpanan_sukarela"] ?? 0,
                                    "simp_wajib" =>
                                        $row[
                                            "simpanan_wajib_sampai_desember_" .
                                                $this->tahun-1
                                        ] ?? 0,
                                ]
                            );
                            $totalSimpananTahunIni = 0;
                            // Handle the monthly transactions
                            foreach (
                                [
                                    "Jan",
                                    "Feb",
                                    "Mar",
                                    "Apr",
                                    "May",
                                    "Jun",
                                    "Jul",
                                    "Aug",
                                    "Sep",
                                    "Oct",
                                    "Nov",
                                    "Dec",
                                ]
                                as $index => $month
                            ) {
                                if ($row[strtolower($month)] !== "-") {
                                    if ($row[strtolower($month)] == null) {
                                        continue;
                                    }
                                    Transaksi::updateOrCreate(
                                        [
                                            "user_id" => $user->id,
                                            "date_transaction" => Carbon::create(
                                                $this->tahun,
                                                $index + 1,
                                                1
                                            )->format("Y-m-d"),
                                        ],
                                        [
                                            "transaction_type" =>
                                                "Simpanan Wajib", // Define or fetch appropriate type
                                            "description" =>
                                                "Monthly transaction for " .
                                                $month,
                                            "nominal" =>
                                                $row[strtolower($month)],
                                        ]
                                    );
                                    $totalSimpananTahunIni += $row[strtolower($month)];
                                }
                            }
                            // Update or create Tabungan record Tahun ini
                            Tabungan::updateOrCreate(
                                [   "user_id" => $user->id,
                                    "tabungan_tahun" => $this->tahun,
                                ],
                                [
                                    "simp_pokok" => $row["simpanan_pokok"] ?? 0,
                                    "simp_sukarela" =>
                                        $row["simpanan_sukarela"] ?? 0,
                                    "simp_wajib" =>$row["simpanan_wajib_sampai_desember_" .$this->tahun-1]+$totalSimpananTahunIni ?? 0,
                                ]
                            );

                        }

                        else {
                            // Update or create Tabungan record Tahun Lalu
                            Tabungan::updateOrCreate(
                                [
                                    "user_id" => $user->id,
                                    "tabungan_tahun" => $this->tahun-1,
                                ],
                                [
                                    "simp_pokok" => $row["simpanan_pokok"] ?? 0,
                                    "simp_sukarela" =>
                                        $row["simpanan_sukarela"] ?? 0,
                                    "simp_wajib" =>
                                        $row[
                                            "simpanan_wajib_sampai_desember_" .
                                                $this->tahun -
                                                1
                                        ] ?? 0,
                                ]
                            );
                            $totalSimpananTahunIni = 0;
                            // Handle the monthly transactions
                            foreach (
                                [
                                    "Jan",
                                    "Feb",
                                    "Mar",
                                    "Apr",
                                    "May",
                                    "Jun",
                                    "Jul",
                                    "Aug",
                                    "Sep",
                                    "Oct",
                                    "Nov",
                                    "Dec",
                                ]
                                as $index => $month
                            ) {
                                if ($row[strtolower($month)] !== "-") {
                                    if ($row[strtolower($month)] == null) {
                                        continue;
                                    }
                                    Transaksi::updateOrCreate(
                                        [
                                            "user_id" => $user->id,
                                            "date_transaction" => Carbon::create(
                                                $this->tahun,
                                                $index + 1,
                                                1
                                            )->format("Y-m-d"),
                                        ],
                                        [
                                            "transaction_type" =>
                                                "Simpanan Wajib", // Define or fetch appropriate type
                                            "description" =>
                                                "Monthly transaction for " .
                                                $month,
                                            "nominal" =>
                                                $row[strtolower($month)],
                                        ]
                                    );
                                    $totalSimpananTahunIni += $row[strtolower($month)];
                                }
                            }
                            // Update or create Tabungan record Tahun ini
                            Tabungan::updateOrCreate(
                                [
                                    "user_id" => $user->id,
                                    "tabungan_tahun" => $this->tahun,
                                ],
                                [
                                    "simp_pokok" => $row["simpanan_pokok"] ?? 0,
                                    "simp_sukarela" =>
                                        $row["simpanan_sukarela"] ?? 0,
                                        "simp_wajib" =>$row["simpanan_wajib_sampai_desember_" .$this->tahun-1]+$totalSimpananTahunIni ?? 0,
                                ]
                            );
                        }
                    }
                }
            },
            $file
        );

        return redirect()
            ->back()
            ->with("success", "Data imported successfully!");
    }

    public function table_simpanan()
    {
        $users = User::with("transactions")->get();
        $years = [];

        foreach ($users as $user) {
            foreach ($user->transactions as $transaction) {
                $date = Carbon::parse($transaction->date_transaction);
                $year = $date->year;

                $years[] = $year;
            }
        }

        $years = array_unique($years);
        sort($years, SORT_NUMERIC);

        return view("dashboard.pages.table_simpanan", compact("years"));
    }

    public function loadTabelSimpananan(Request $request)
    {
        $year = $request->input("year", Carbon::now()->year);
        $startYear = max($year, 2018);

        // Load users with their transactions, savings, and golongan
        $users = User::with(["transactions", "savings", "golongan"])->get();
        $userYearlySavings = [];

        foreach ($users as $user) {
            $userId = $user->id;
            $simpananPokok = $user->golongan->simp_pokok;
            $tabungan = $user->savings->first();
            $simpananSukarela = $tabungan ? $tabungan->simp_sukarela : 0;
            $simpananWajib = $tabungan ? $tabungan->simp_wajib : 0;

            if (!isset($userYearlySavings[$userId])) {
                $userYearlySavings[$userId] = [];
            }

            for (
                $currentYear = $startYear;
                $currentYear <= 2024;
                $currentYear++
            ) {
                if (!isset($userYearlySavings[$userId][$currentYear])) {
                    $userYearlySavings[$userId][$currentYear] = array_fill(
                        1,
                        12,
                        0
                    );
                    $userYearlySavings[$userId][$currentYear][
                        "simpananWajib_$currentYear"
                    ] = 0;
                    $userYearlySavings[$userId][$currentYear][
                        "JumlahSimpanan_$currentYear"
                    ] = 0;
                    $userYearlySavings[$userId][$currentYear][
                        "simpananPokok"
                    ] = $simpananPokok;
                    $userYearlySavings[$userId][$currentYear][
                        "simpananSukarela"
                    ] = $simpananSukarela;
                }
            }

            foreach ($user->transactions as $data) {
                $date = Carbon::parse($data->date_transaction);
                $transactionYear = $date->year;
                $month = $date->format("n");

                if (
                    $transactionYear >= $startYear &&
                    $transactionYear <= 2024
                ) {
                    $userYearlySavings[$userId][$transactionYear][$month] +=
                        $data->nominal;
                    $userYearlySavings[$userId][$transactionYear][
                        "simpananWajib_$transactionYear"
                    ] += $data->nominal;
                }
            }
        }

        $data = [];
        foreach ($userYearlySavings as $userId => $yearlyData) {
            $user = User::find($userId);
            if ($user->role->name == "Administrator") {
                continue;
            }

            $cumulativeSimpanan = 0;

            foreach ($yearlyData as $yearlyYear => &$savings) {
                $simpananWajib_perTahun = $savings["simpananWajib_$yearlyYear"];

                $savings["JumlahSimpanan_$yearlyYear"] =
                    $savings["simpananPokok"] +
                    $savings["simpananSukarela"] +
                    $simpananWajib_perTahun;

                if ($yearlyYear == $year) {
                    $cumulativeSimpanan =
                        $savings["JumlahSimpanan_$yearlyYear"];
                }
            }

            $row = $yearlyData[$year] ?? array_fill(1, 12, 0);
            $row["JumlahSimpanan_$year"] = $cumulativeSimpanan;
            $row["totalTabungan"] = $simpananWajibFinal =
                $row["JumlahSimpanan_$year"] * 0.8;
            $jumlahSimpanan2024 =
                $simpananWajibFinal +
                $row["simpananPokok"] +
                $row["simpananSukarela"];

            $data[] = [
                "id" => $userId,
                "anggota" => $user->name,
                "januari" => $this->formatCurrency($row[1]),
                "februari" => $this->formatCurrency($row[2]),
                "maret" => $this->formatCurrency($row[3]),
                "april" => $this->formatCurrency($row[4]),
                "mei" => $this->formatCurrency($row[5]),
                "juni" => $this->formatCurrency($row[6]),
                "juli" => $this->formatCurrency($row[7]),
                "agustus" => $this->formatCurrency($row[8]),
                "september" => $this->formatCurrency($row[9]),
                "oktober" => $this->formatCurrency($row[10]),
                "november" => $this->formatCurrency($row[11]),
                "desember" => $this->formatCurrency($row[12]),
                "simpanan_pokok" => $this->formatCurrency(
                    $row["simpananPokok"]
                ),
                "simpanan_sukarela" => $this->formatCurrency(
                    $row["simpananSukarela"]
                ),
                "simpanan_wajib_sampai_desember" => $this->formatCurrency(
                    $row["JumlahSimpanan_$year"]
                ),
                "setelah_dikurangi_20%" => $this->formatCurrency(
                    $simpananWajibFinal
                ),
                "jumlah_simpanan_2024" => $this->formatCurrency(
                    $jumlahSimpanan2024
                ),
                "tahun" => $year,
                "total" => $this->formatCurrency($row["JumlahSimpanan_$year"]),
                "total_tabungan" => $this->formatCurrency(
                    $row["totalTabungan"]
                ),
            ];
        }
        return response()->json(["data" => $data]);
    }

    private function formatCurrency($value)
    {
        return "Rp" . number_format($value, 0, ",", ".");
    }
}
