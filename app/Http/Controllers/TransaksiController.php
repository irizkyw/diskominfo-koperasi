<?php

namespace App\Http\Controllers;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\Tabungan;

class TransaksiController extends Controller
{
    //
    public function index()
    {
        return view('transaksi.index');
    }

    public function cekTransaksiAll()
    {
        $transaksi = Transaksi::all();
        return response()->json($transaksi);
    }

    public function cekLogTransaksiByUserId($id)
    {
        $transaksi = Transaksi::where('user_id', $id)->get();
        return response()->json($transaksi);
    }

    public function cekTransaksiSimpananBulananByUserId($id)
    {
        $transaksi = Transaksi::where('user_id', $id)->where('transaction_type', 'SIMPANAN-BULANAN')->get();
        return response()->json($transaksi);
    }

    public function SumTransaksiSimpananBulananByUserId($id)
    {
        $total = Transaksi::where('user_id', $id)
                        ->where('transaction_type', 'SIMPANAN-BULANAN')
                        ->sum('nominal');

        return response()->json(['total_nominal' => $total]);
    }

    
}
