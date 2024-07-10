<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function cekTransaksiSimpananByUserId($id)
    {
        $transaksi = Transaksi::where('user_id', $id)->where('jenis_transaksi', 'SIMPANAN-BULANAN')->get();
        return response()->json($transaksi);
    }
}
