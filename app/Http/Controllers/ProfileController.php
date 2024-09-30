<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Golongan;
use App\Models\Transaksi;
use App\Models\Tabungan;
use App\Models\Event;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = $request->user();

            if ($user && $user->isAdmin()) {
                return $next($request);
            }

            if ($request->routeIs("profile")) {
                $userId = $request->input("user_id", $user->id);
                if ($userId != $user->id) {
                    abort(403, "Unauthorized.");
                }
            }

            return $next($request);
        })->only(["index", "monthly"]);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $userId = $request->input("user_id", $user->id);

        $User = User::with(["role", "golongan", "transaksi"])->find($userId);

        if (!$User) {
            abort(404, "User not found");
        }

        $soonThreshold = Carbon::now()->addWeek();
        $event = Event::where("tanggal_event", ">=", Carbon::now())
            ->where("tanggal_event", "<=", $soonThreshold)
            ->orderBy("tanggal_event")
            ->first();

        $Role = $User->role;
        $Golongan = $User->golongan;

        $LogTransaksi = $User
            ->transaksi()
            ->orderBy("created_at", "desc")
            ->get();

        $latestTabungan = Tabungan::where("user_id", $User->id)
            ->orderBy("tabungan_tahun", "desc")
            ->first();

        $year = Carbon::now()->year;
        $previousYear = $year - 1;

        $monthlyTotals = array_fill(1, 12, 0);
        $simpananSukarela = $latestTabungan->simp_sukarela ?? 0;
        $simpananWajibTahunIni = 0;

        foreach ($User->transaksi as $transaction) {
            $date = Carbon::parse($transaction->date_transaction);
            $transactionYear = $date->year;
            $month = $date->format("n");

            if ($transactionYear == $year) {
                $monthlyTotals[$month] += $transaction->nominal;
                $simpananWajibTahunIni += $transaction->nominal;
                if ($transaction->transaction_type == "Simpanan Sukarela") {
                    $simpananSukarela += $transaction->nominal;
                }
            }
        }

        $latestTabunganSimpananWajib = $latestTabungan->simp_wajib ?? 0;

        $simpananPokok = $latestTabungan->simp_pokok ?? 0;
        $SimpananAkhir =
            $latestTabunganSimpananWajib + $simpananPokok + $simpananSukarela;

        return view(
            "dashboard.pages.profile",
            compact(
                "User",
                "Role",
                "Golongan",
                "SimpananAkhir",
                "LogTransaksi",
                "event"
            )
        );
    }

    public function monthly(Request $request)
    {
        $userId = (int) $request->input("user_id", $request->user()->id);

        // Retrieve user savings data
        $savings = User::find($userId)->savings->first();
        $simpananPokok = $savings->simp_pokok ?? 0;

        // Retrieve all relevant transactions
        $rawData = DB::table("transaksi")
            ->select(
                DB::raw("YEAR(date_transaction) as year"),
                DB::raw("MONTH(date_transaction) as month"),
                DB::raw("transaction_type"),
                DB::raw("SUM(nominal) as total_nominal")
            )
            ->where("user_id", $userId)
            ->whereIn("transaction_type", [
                "Simpanan Wajib",
                "Simpanan Sukarela",
                "Simpanan Pokok",
            ])
            ->groupBy(
                DB::raw("YEAR(date_transaction)"),
                DB::raw("MONTH(date_transaction)"),
                "transaction_type"
            )
            ->get();

        $years = Tabungan::where("user_id", $userId)
            ->select(DB::raw("DISTINCT(tabungan_tahun) as year"))
            ->pluck("year")
            ->toArray();

        $firstYear = min($years);
        $lastYear = max($years);

        $pivotedData = [];
        for ($year = $firstYear; $year <= $lastYear; $year++) {
            $pivotedData[$year] = array_fill(1, 12, 0);
            $pivotedData[$year]["total"] = 0;
            $pivotedData[$year]["simpanan_sukarela"] = 0;
        }

        foreach ($rawData as $entry) {
            $year = $entry->year;
            $month = $entry->month;
            $transactionType = $entry->transaction_type;
            $totalNominal = $entry->total_nominal;

            // Check if year exists in pivotedData, if not initialize it
            if (!isset($pivotedData[$year])) {
                $pivotedData[$year] = array_fill(1, 12, 0);
                $pivotedData[$year]["total"] = 0;
                $pivotedData[$year]["simpanan_sukarela"] = 0;
            }

            // Proceed with adding nominal
            $pivotedData[$year][$month] += $totalNominal;
            $pivotedData[$year]["total"] += $totalNominal;

            if ($transactionType == "Simpanan Sukarela") {
                $pivotedData[$year]["simpanan_sukarela"] += $totalNominal;
            }
        }

        $data = [];
        foreach ($pivotedData as $year => $months) {
            if ($months["total"] > 0 || $months["simpanan_sukarela"] > 0) {
                $previousYear = $year - 1;

                $totalTabunganSimpananWajib = Tabungan::where(
                    "user_id",
                    $userId
                )
                    ->where("tabungan_tahun", $year)
                    ->sum("simp_wajib");

                $simpananWajibTahunIni = $months["total"];
                $jumlahSimpananAfterReduction =
                    ($totalTabunganSimpananWajib + $simpananWajibTahunIni) *
                    0.8;
                $totalTabungan =
                    $totalTabunganSimpananWajib +
                    $simpananPokok +
                    $months["simpanan_sukarela"];

                $row = [
                    "simp_pokok" => $this->formatCurrency($simpananPokok),
                    "simp_sukarela" => $this->formatCurrency(
                        $months["simpanan_sukarela"]
                    ),
                    "year" => $year,
                    "tabungan_" . $previousYear => $this->formatCurrency(
                        $totalTabunganSimpananWajib
                    ),
                    "tabungan_" . $year => $this->formatCurrency(
                        $totalTabunganSimpananWajib
                    ),
                    "jumlahSimpanan_AfterReduction" => $this->formatCurrency(
                        $jumlahSimpananAfterReduction
                    ),
                    "total_simpanan_currentYear" => $this->formatCurrency(
                        $simpananWajibTahunIni
                    ),
                    "total_tabungan" => $this->formatCurrency($totalTabungan),
                    "january" => $this->formatCurrency($months[1]),
                    "february" => $this->formatCurrency($months[2]),
                    "march" => $this->formatCurrency($months[3]),
                    "april" => $this->formatCurrency($months[4]),
                    "may" => $this->formatCurrency($months[5]),
                    "june" => $this->formatCurrency($months[6]),
                    "july" => $this->formatCurrency($months[7]),
                    "august" => $this->formatCurrency($months[8]),
                    "september" => $this->formatCurrency($months[9]),
                    "october" => $this->formatCurrency($months[10]),
                    "november" => $this->formatCurrency($months[11]),
                    "december" => $this->formatCurrency($months[12]),
                ];

                $data[] = $row;
            }
        }

        return DataTables::of($data)->addIndexColumn()->make(true);
    }

    protected function formatCurrency($value)
    {
        return $value == 0 ? "-" : "Rp" . number_format($value, 0, ",", ".");
    }

    public function updateProfile(Request $request)
    {
        $request->validate(
            [
                "username" =>
                    "required|string|max:255|unique:users,username," .
                    Auth::id(),
                "old_password" => "required|string",
                "password" => "nullable|string|min:4|confirmed",
            ],
            [
                "username.unique" => "Username telah dipakai oleh orang lain.",
            ]
        );

        $user = Auth::user();

        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()
                ->back()
                ->with("error", "Password lama tidak sesuai");
        }

        $user->username = $request->username;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()
            ->back()
            ->with("success", "Profil berhasil diperbarui");
    }
}
