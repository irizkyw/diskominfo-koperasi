<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Golongan;
use App\Models\Transaksi;
use App\Models\Tabungan;
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

    $Role = $User->role;
    $Golongan = $User->golongan;

    $latestTabungan = Tabungan::where("user_id", $User->id)
        ->orderBy("created_at", "desc")
        ->first();

    $year = Carbon::now()->year;
    $previousYear = $year - 1;

    $monthlyTotals = array_fill(1, 12, 0);
    $simpananSukarela = $latestTabungan->simp_sukarela ?? 0;
    $simpananWajibTahunIni = 0;

    foreach ($User->transaksi as $transaction) {
        $date = Carbon::parse($transaction->date_transaction);
        $transactionYear = $date->year;
        $month = $date->format('n');

        if ($transactionYear == $year) {
            $monthlyTotals[$month] += $transaction->nominal;
            $simpananWajibTahunIni += $transaction->nominal;
            if ($transaction->transaction_type == 'Simpanan Sukarela') {
                $simpananSukarela += $transaction->nominal;
            }
        }
    }
    $LogTransaksi = $User
                ->transaksi()
                ->orderBy("created_at", "desc")
                ->get();

    $totalTabunganSimpananWajib = Tabungan::where('user_id', $User->id)
        ->where('tabungan_tahun', '<=', $year)
        ->sum('simp_wajib');

    $simpananPokok = $latestTabungan->simp_pokok ?? 0;
    $SimpananAkhir = $totalTabunganSimpananWajib + $simpananPokok + $simpananSukarela;


    return view(
        "dashboard.pages.profile",
        compact(
            "User",
            "Role",
            "Golongan",
            "SimpananAkhir",
            "LogTransaksi"
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

        // Retrieve all relevant years from the tabungan table
        $years = Tabungan::where('user_id', $userId)
            ->select(DB::raw('DISTINCT(tabungan_tahun) as year'))
            ->pluck('year')
            ->toArray();

        $firstYear = min($years); // Earliest year in tabungan
        $lastYear = max($years); // Latest year in tabungan

        // Initialize an array to hold the data for all years within the range
        $pivotedData = [];
        for ($year = $firstYear; $year <= $lastYear; $year++) {
            $pivotedData[$year] = array_fill(1, 12, 0); // Fill months 1-12 with 0
            $pivotedData[$year]["total"] = 0;
            $pivotedData[$year]["simpanan_sukarela"] = 0; // Initialize simpanan sukarela for each year
        }

        // Populate the data with transactions
        foreach ($rawData as $entry) {
            $year = $entry->year;
            $month = $entry->month;
            $transactionType = $entry->transaction_type;
            $totalNominal = $entry->total_nominal;

            // Add monthly contributions
            $pivotedData[$year][$month] += $totalNominal;
            $pivotedData[$year]["total"] += $totalNominal;

            // Aggregate Simpanan Sukarela for the specific year
            if ($transactionType == 'Simpanan Sukarela') {
                $pivotedData[$year]["simpanan_sukarela"] += $totalNominal;
            }
        }

        // Prepare the final data
        $data = [];
        foreach ($pivotedData as $year => $months) {
            // Check if there is any transaction data for this year
            if ($months["total"] > 0 || $months["simpanan_sukarela"] > 0) {
                $previousYear = $year - 1;

                // Retrieve total savings for the year from the tabungan table
                $totalTabunganSimpananWajib = Tabungan::where('user_id', $userId)
                    ->where('tabungan_tahun', '<=', $year)
                    ->sum('simp_wajib');

                $simpananWajibTahunIni = $months["total"];
                $jumlahSimpananAfterReduction = ($totalTabunganSimpananWajib + $simpananWajibTahunIni) * 0.8;
                $totalTabungan = $totalTabunganSimpananWajib + $simpananPokok + $months["simpanan_sukarela"];

                $row = [
                    'simp_pokok' => $this->formatCurrency($simpananPokok),
                    'simp_sukarela' => $this->formatCurrency($months["simpanan_sukarela"]),
                    'year' => $year,
                    'tabungan_' . $previousYear => $this->formatCurrency($totalTabunganSimpananWajib),
                    'tabungan_' . $year => $this->formatCurrency($totalTabunganSimpananWajib),
                    'jumlahSimpanan_AfterReduction' => $this->formatCurrency($jumlahSimpananAfterReduction),
                    'total_simpanan_currentYear' => $this->formatCurrency($simpananWajibTahunIni),
                    'total_tabungan' => $this->formatCurrency($totalTabungan),
                    'january' => $this->formatCurrency($months[1]),
                    'february' => $this->formatCurrency($months[2]),
                    'march' => $this->formatCurrency($months[3]),
                    'april' => $this->formatCurrency($months[4]),
                    'may' => $this->formatCurrency($months[5]),
                    'june' => $this->formatCurrency($months[6]),
                    'july' => $this->formatCurrency($months[7]),
                    'august' => $this->formatCurrency($months[8]),
                    'september' => $this->formatCurrency($months[9]),
                    'october' => $this->formatCurrency($months[10]),
                    'november' => $this->formatCurrency($months[11]),
                    'december' => $this->formatCurrency($months[12]),
                ];

                $data[] = $row;
            }
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->make(true);
    }


    protected function formatCurrency($value)
    {
        return $value == 0 ? '-' : "Rp" . number_format($value, 0, ",", ".");
    }



    public function updatePassword(Request $request)
    {
        $request->validate([
            "password" => "required|string|min:4|confirmed",
        ]);

        $user = Auth::user();

        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()
                ->back()
                ->with("success", "Password berhasil direset");
        }
        return redirect()->back()->with("error", "Password lama tidak sesuai");
    }
}
