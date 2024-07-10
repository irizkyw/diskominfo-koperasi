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
        $SimpananWajibLast = Tabungan::where('user_id', $id)->first()->mandatory_savings;
        $SimpananWajibTemp = Transaksi::where('user_id', $id)
                        ->where('transaction_type', 'SIMPANAN-BULANAN')
                        ->sum('nominal');
        $totalSimpananWajib = $SimpananWajibLast + $SimpananWajibTemp;
        return response()->json(['SimpananBulanan' => $totalSimpananWajib]);
    }

    public function SumTransaksiSimpananAkhirByUserId($id)
    {
        $SimpananWajibLast = Tabungan::where('user_id', $id)->first()->mandatory_savings; //Simpanan Wajib Terakhir
        $SimpananWajib = Transaksi::where('user_id', $id)
                        ->where('transaction_type', 'SIMPANAN-BULANAN')
                        ->sum('nominal'); //Total Simpanan Wajib Bulanan
        $SimpananWajib = $SimpananWajibLast + $SimpananWajib; //Simpanan Wajib hingga saat ini
        $SimpananWajib80 = $SimpananWajib * 0.8; //80% dari total simpanan bulanan || Setelah dikurangi 20%

        $SimpananPokok = Tabungan::where('user_id', $id)->first()->principal_savings;
        $SimpananSukarela = Tabungan::where('user_id', $id)->first()->voluntary_savings;
        $SimpananAkhir = $SimpananWajib80 + $SimpananPokok + $SimpananSukarela; 
        return response()->json([   
                                    'SimpananWajibLast' => $SimpananWajibLast,
                                    'SimpananSukarela' => $SimpananSukarela,
                                    'SimpananPokok' => $SimpananPokok,             
                                    'SimpananWajibNow' => $SimpananWajib,
                                    'SimpananWajib80' => $SimpananWajib80,
                                    'SimpananAkhir' => $SimpananAkhir]);
    }
}
