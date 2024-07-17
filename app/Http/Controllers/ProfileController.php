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
    $rawData = DB::table('transaksi')
        ->select(
            'user_id',
            DB::raw('YEAR(date_transaction) as year'),
            DB::raw('MONTH(date_transaction) as month'),
            DB::raw('SUM(nominal) as total_nominal')
        )
        ->where('user_id', Auth::id())
        ->whereIn('transaction_type', ['Simpanan Wajib', 'Simpanan Sukarela'])
        ->groupBy(
            DB::raw('YEAR(date_transaction)'),
            DB::raw('MONTH(date_transaction)'),
            'user_id'
        )
        ->get();

    $pivotedData = [];
    foreach ($rawData as $entry) {
        $year = $entry->year;
        $month = $entry->month;
        $total_nominal = $entry->total_nominal;

        if (!isset($pivotedData[$year])) {
            $pivotedData[$year] = array_fill(1, 12, 0); // Fill months 1-12 with 0
            $pivotedData[$year]['total'] = 0;
        }

        $pivotedData[$year][$month] = $total_nominal;
        $pivotedData[$year]['total'] += $total_nominal;
    }

    // Format data for DataTables
    $data = [];
    foreach ($pivotedData as $year => $months) {
        $row = [
            'year' => $year,
            'january' => $months[1],
            'february' => $months[2],
            'march' => $months[3],
            'april' => $months[4],
            'may' => $months[5],
            'june' => $months[6],
            'july' => $months[7],
            'august' => $months[8],
            'september' => $months[9],
            'october' => $months[10],
            'november' => $months[11],
            'december' => $months[12],
            'total' => $months['total']
        ];
        $data[] = $row;
    }

return DataTables::of($data)
    ->addIndexColumn()
    ->addColumn('year', function($row){
        return $row['year'];
    })
    ->addColumn('january', function($row){
        return $row['january'] == 0 ? '-' : 'Rp' . number_format($row['january'], 0, ',', '.');
    })
    ->addColumn('february', function($row){
        return $row['february'] == 0 ? '-' : 'Rp' . number_format($row['february'], 0, ',', '.');
    })
    ->addColumn('march', function($row){
        return $row['march'] == 0 ? '-' : 'Rp' . number_format($row['march'], 0, ',', '.');
    })
    ->addColumn('april', function($row){
        return $row['april'] == 0 ? '-' : 'Rp' . number_format($row['april'], 0, ',', '.');
    })
    ->addColumn('may', function($row){
        return $row['may'] == 0 ? '-' : 'Rp' . number_format($row['may'], 0, ',', '.');
    })
    ->addColumn('june', function($row){
        return $row['june'] == 0 ? '-' : 'Rp' . number_format($row['june'], 0, ',', '.');
    })
    ->addColumn('july', function($row){
        return $row['july'] == 0 ? '-' : 'Rp' . number_format($row['july'], 0, ',', '.');
    })
    ->addColumn('august', function($row){
        return $row['august'] == 0 ? '-' : 'Rp' . number_format($row['august'], 0, ',', '.');
    })
    ->addColumn('september', function($row){
        return $row['september'] == 0 ? '-' : 'Rp' . number_format($row['september'], 0, ',', '.');
    })
    ->addColumn('october', function($row){
        return $row['october'] == 0 ? '-' : 'Rp' . number_format($row['october'], 0, ',', '.');
    })
    ->addColumn('november', function($row){
        return $row['november'] == 0 ? '-' : 'Rp' . number_format($row['november'], 0, ',', '.');
    })
    ->addColumn('december', function($row){
        return $row['december'] == 0 ? '-' : 'Rp' . number_format($row['december'], 0, ',', '.');
    })
    ->addColumn('total', function($row){
        return 'Rp' . number_format($row['total'], 0, ',', '.');
    })
    ->make(true);
}

}
