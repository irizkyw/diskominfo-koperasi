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


class ProfileController extends Controller
{
    public function index()
    {
        $User = Auth::user();
        $id = $User->id;

        $Role = Role::find($User->role_id);
        $Golongan = Golongan::find($User->golongan_id);
        $LogTransaksi = Transaksi::where('user_id', $User->id)->get();
        $LogSimpananBulanan = Transaksi::where('user_id', $User->id)->where('transaction_type', 'Simpanan Wajib')->get();

        // Retrieve Simpanan Wajib Last
        $SimpananWajibLast = Tabungan::where('user_id', $id)->first()->simp_wajib; // Simpanan Wajib Terakhir
        $SimpananWajib = Transaksi::where('user_id', $id)
            ->where('transaction_type', 'Simpanan Wajib')
            ->sum('nominal'); // Total Simpanan Wajib Bulanan
        $SimpananWajib = $SimpananWajibLast + $SimpananWajib; // Simpanan Wajib hingga saat ini
        $SimpananWajib80 = $SimpananWajib * 0.8; // 80% dari total simpanan bulanan || Setelah dikurangi 20%

        $SimpananPokok = Tabungan::where('user_id', $id)->first()->simp_pokok;
        $SimpananSukarela = Tabungan::where('user_id', $id)->first()->simp_sukarela;
        $SimpananAkhir = $SimpananWajib80 + $SimpananPokok + $SimpananSukarela;

        // Retrieve grouped transaction data
        $monthlySimpananWajib = DB::table('transaksi')
            ->select(
                'user_id',
                DB::raw('YEAR(date_transaction) as year'),
                DB::raw('MONTH(date_transaction) as month'),
                'transaction_type',
                DB::raw('COUNT(*) as total_entries'),
                DB::raw('SUM(nominal) as total_nominal')
            )
            ->where('user_id', $id)
            ->where('transaction_type', 'Simpanan Wajib')
            ->groupBy(
                DB::raw('YEAR(date_transaction)'),
                DB::raw('MONTH(date_transaction)'),
                'user_id',
                'transaction_type'
            )
            ->get();

        return view(
            'dashboard.pages.profile',
            compact(
                'User',
                'Role',
                'Golongan',
                'LogTransaksi',
                'LogSimpananBulanan',
                'SimpananWajib',
                'SimpananPokok',
                'SimpananSukarela',
                'SimpananAkhir',
                'monthlySimpananWajib'
            )
        );
    }

    public function monthly()
    {
        // Query to fetch monthly transaction data
        $query = DB::table('transaksi')
            ->select(
                'user_id',
                DB::raw('YEAR(date_transaction) as year'),
                DB::raw('MONTH(date_transaction) as month'),
                'transaction_type',
                DB::raw('COUNT(*) as total_entries'),
                DB::raw('SUM(nominal) as total_nominal')
            )
            ->where('user_id', Auth::id()) // Filter by authenticated user ID
            ->where('transaction_type', 'Simpanan Wajib') // Filter by transaction type
            ->groupBy(
                DB::raw('YEAR(date_transaction)'),
                DB::raw('MONTH(date_transaction)'),
                'user_id',
                'transaction_type'
            );

        // Return DataTables response with formatted columns
        dd($query);
        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('year', function($row){
                return $row->year;
            })
            ->addColumn('month', function($row){
                return $row->month;
            })
            ->addColumn('total_entries', function($row){
                return $row->total_entries;
            })
            ->addColumn('total_nominal', function($row){
                return $row->total_nominal;
            })
            ->make(true); // Returns the JSON response for DataTables
    }



}
