<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tabungan;
use App\Models\Transaksi;
class TabunganController extends Controller
{
    public function index()
    {
        return view('tabungan.index');
    }

    public function cekTabunganAll()
    {
        $tabungan = Tabungan::all();
        return response()->json($tabungan);
    }

    public function cekTabunganByUserAuth()
    {
        $user = Auth::user();
        $tabungan = Tabungan::where('user_id', 2)->first();
        return response()->json($user);
    }

    public function cekTabunganByUserId($id)
    {
        $tabungan = Tabungan::where('user_id', $id)->first();
        return response()->json($tabungan);
    }

    public function updateSimpananBulananUser($id)
    {
        $total = Transaksi::where('user_id', $id)
                        ->where('transaction_type', 'Simpanan Wajib')
                        ->sum('nominal');

        $transaksi = Tabungan::where('user_id', $id)
                    ->update(['mandatory_savings' => $total]);

        $tglUpdate = Tabungan::where('user_id', $id)->first()->updated_at;

        return response()->json(['Berhasil' => $transaksi,
                                'Total Simpanan' => $total,
                                'TglUpdate' => $tglUpdate]);
    }
}
