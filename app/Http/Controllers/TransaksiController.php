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

    public function LogAllTransaksiByUserId($id)
    {
        $transaksi = Transaksi::where('user_id', $id)->get();
        return response()->json($transaksi);
    }

    public function LogAllTransaksiByUserLogged()
    {
        $User = Auth::user();
        $transaksi = Transaksi::where('user_id', $User->id)->get();
        return response()->json($transaksi);
    }

    public function LogTransaksiSimpananBulananByUserId($id)
    {
        $transaksi = Transaksi::where('user_id', $id)
                              ->where('transaction_type', 'SIMPANAN-BULANAN')
                              ->get();

        $transaksi->each(function ($item) {
            $date = new \DateTime($item->date_transaction);
            $item->bulan_simpanan = $date->format('F');
        });

        return response()->json($transaksi);
    }

    public function LogTransaksiSimpananBulananByUserLogged()
    {
        $User = Auth::user();
        $transaksi = Transaksi::where('user_id', $User->id)
                              ->where('transaction_type', 'SIMPANAN-BULANAN')
                              ->get();

        $transaksi->each(function ($item) {
            $date = new \DateTime($item->date_transaction);
            $item->bulan_simpanan = $date->format('F');
        });

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

    public function SumTransaksiSimpananBulananByUserLogged()
    {
        $User = Auth::user();
        $SimpananWajibLast = Tabungan::where('user_id', $User->id)->first()->mandatory_savings;
        $SimpananWajibTemp = Transaksi::where('user_id', $User->id)
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
        $SimpananWajib = $SimpananWajib * 0.8; //80% dari total simpanan bulanan || Setelah dikurangi 20%

        $SimpananPokok = Tabungan::where('user_id', $id)->first()->principal_savings;
        $SimpananSukarela = Tabungan::where('user_id', $id)->first()->voluntary_savings;
        $SimpananAkhir = $SimpananWajib + $SimpananPokok + $SimpananSukarela; 
        return response()->json(['SimpananAkhir' => $SimpananAkhir]);
    }

    public function LaporanByUserId($id)
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

    public function LaporanByUserLogged()
    {
        $User = Auth::user();
        $id = $User->id;
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

    public function cekTransaksiByUserId($id)
    {
        $transaksi = Transaksi::where('user_id', $id)->get();
        return response()->json($transaksi);
    }

    public function cekTransaksiByType($type)
    {
        $transaksi = Transaksi::where('transaction_type', $type)->get();
        return response()->json($transaksi);
    }

    public function cekTransaksiByDate($date)
    {
        $transaksi = Transaksi::where('date_transaction', $date)->get();
        return response()->json($transaksi);
    }

    
    
}
