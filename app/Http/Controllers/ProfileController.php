<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $User = User::Auth();
        $id = $User->id;

        $Role = Role::find($User->role_id);
        $Golongan = Golongan::find($User->golongan_id);
        $LogTransaksi = Transaksi::where('user_id', $User->id)->get();
        $LogSimpananBulanan = Transaksi::where('user_id', $User->id)->where('jenis_transaksi', 'Simpanan Wajib')->get();


        $SimpananWajibLast = Tabungan::where('user_id', $id)->first()->simp_wajib; //Simpanan Wajib Terakhir
        $SimpananWajib = Transaksi::where('user_id', $id)
                        ->where('transaction_type', 'Simpanan Wajib')
                        ->sum('nominal'); //Total Simpanan Wajib Bulanan
        $SimpananWajib = $SimpananWajibLast + $SimpananWajib; //Simpanan Wajib hingga saat ini
        $SimpananWajib80 = $SimpananWajib * 0.8; //80% dari total simpanan bulanan || Setelah dikurangi 20%

        $SimpananPokok = Tabungan::where('user_id', $id)->first()->simp_pokok;
        $SimpananSukarela = Tabungan::where('user_id', $id)->first()->simp_sukarela;
        $SimpananAkhir = $SimpananWajib80 + $SimpananPokok + $SimpananSukarela;

        return view('dashboard.pages.profile', compact('User','Role','Golongan','LogTransaksi','SimpananBulanan','SimpananWajib','SimpananPokok','SimpananSukarela','SimpananAkhir'));
    }
}
