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
        $LogSimpananBulanan = Transaksi::where('user_id', $User->id)->where('jenis_transaksi', 'SIMPANAN-BULANAN')->get();
        
        
        $SimpananWajibLast = Tabungan::where('user_id', $id)->first()->mandatory_savings; //Simpanan Wajib Terakhir
        $SimpananWajib = Transaksi::where('user_id', $id)
                        ->where('transaction_type', 'SIMPANAN-BULANAN')
                        ->sum('nominal'); //Total Simpanan Wajib Bulanan
        $SimpananWajib = $SimpananWajibLast + $SimpananWajib; //Simpanan Wajib hingga saat ini
        $SimpananWajib80 = $SimpananWajib * 0.8; //80% dari total simpanan bulanan || Setelah dikurangi 20%

        $SimpananPokok = Tabungan::where('user_id', $id)->first()->principal_savings;
        $SimpananSukarela = Tabungan::where('user_id', $id)->first()->voluntary_savings;
        $SimpananAkhir = $SimpananWajib80 + $SimpananPokok + $SimpananSukarela;

        return view('dashboard.pages.profile', compact('User','Role','Golongan','LogTransaksi','SimpananBulanan','SimpananWajib','SimpananPokok','SimpananSukarela','SimpananAkhir'));
    }
}
