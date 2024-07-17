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
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $user = $request->user();

            if ($user && $user->isAdmin()) {
                return $next($request);
            }

            if ($request->routeIs('profile')) {
                $userId = $request->input('user_id', $user->id);
                if ($userId != $user->id) {
                    abort(403, 'Unauthorized.');
                }
            }

            return $next($request);
        })->only(['index', 'monthly']);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $userId = $request->input('user_id', $user->id);

        $User = User::find($userId);

        if (!$User) {
            abort(404, 'User not found');
        }

        $Role = Role::find($User->role_id);
        $Golongan = Golongan::find($User->golongan_id);

        $LogTransaksi = Transaksi::where('user_id', $User->id)->get();

        $SimpananWajib = Tabungan::where('user_id', $User->id)->value('simp_wajib') ?? 0;
        $SimpananWajib80 = $SimpananWajib * 0.8;

        $SimpananPokok = Tabungan::where('user_id', $User->id)->value('simp_pokok') ?? 0;
        $SimpananSukarela = Tabungan::where('user_id', $User->id)->value('simp_sukarela') ?? 0;
        $SimpananAkhir = $SimpananWajib80 + $SimpananPokok + $SimpananSukarela;

        return view('dashboard.pages.profile', compact('User', 'Role', 'Golongan', 'LogTransaksi', 'SimpananWajib', 'SimpananPokok', 'SimpananSukarela', 'SimpananAkhir'));
    }

public function monthly(Request $request)
{
    $userId = (int) $request->input('user_id', $request->user()->id);
    $rawData = DB::table('transaksi')
        ->select(
            'user_id',
            DB::raw('YEAR(date_transaction) as year'),
            DB::raw('MONTH(date_transaction) as month'),
            DB::raw('SUM(nominal) as total_nominal')
        )
        ->where('user_id', $userId)
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
            $pivotedData[$year] = array_fill(1, 12, 0);
            $pivotedData[$year]['total'] = 0;
        }

        $pivotedData[$year][$month] = $total_nominal;
        $pivotedData[$year]['total'] += $total_nominal;
    }

    \Log::info('Pivoted Data: ' . json_encode($pivotedData));

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

    \Log::info('Formatted Data: ' . json_encode($data));

    return DataTables::of($data)->make(true);
}


}
