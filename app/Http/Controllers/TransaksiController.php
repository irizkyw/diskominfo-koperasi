<?php

namespace App\Http\Controllers;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Models\Tabungan;
use Yajra\DataTables\DataTables;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransaksiExport;

class TransaksiController extends Controller
{
    public function index()
    {
    $transaksi = Transaksi::orderBy('created_at', 'desc')->get();
    $users = User::all();
    $roles = Role::all();

    return view('dashboard.pages.transaksi', compact('transaksi', 'users', 'roles'));
    }

    public function datatable()
    {
        $query = Transaksi::get();

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('simpanan_id', function($row) {
                return $row->id;
            })
            ->addColumn('user_id', function($row) {
                $name = $row->user->name;
                $golongan = $row->user->savings->first()->golongan->nama_golongan ?? 'Error';
                return "{$name} ({$golongan})";
            })
            ->editColumn('transaction_type', function($row) {
                return $row->transaction_type;
            })
            ->editColumn('description', function($row) {
                return $row->description;
            })
            ->editColumn('date_transaction', function($row) {
                return Carbon::parse($row->date_transaction)->translatedFormat('d F Y');
            })
            ->editColumn('nominal', function($row) {
                return 'Rp. ' . number_format($row->nominal, 0, ',', '.');
            })
            ->addColumn('actions', function($row) {
                return '
                <div class="d-flex justify-content-end">
                    <a href="#"
                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 transaksi-edit"
                        data-id="'. $row->id .'">
                        <span class="svg-icon svg-icon-2">
                            <i class="fas fa-pen"></i>
                        </span>
                    </a>
                    <a href="#"
                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 transaksi-delete"
                        data-id="'. $row->id .'">
                        <span class="svg-icon svg-icon-2">
                            <i class="fas fa-trash"></i>
                        </span>
                    </a>
                    <a href="'. route('profile', ['user_id' => $row->user_id]).'"
                        class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                        <span class="svg-icon svg-icon-2">
                            <i class="fas fa-user"></i>
                        </span>
                    </a>
                </div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }


    public function createSimpanan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'transaction_type' => 'required|string|max:255',
            'desc' => 'required|string|max:255',
            'date_transaction' => 'required|date',
            'nominal' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $transaksi = Transaksi::create([
            'user_id' => $request->user_id,
            'transaction_type' => $request->transaction_type,
            'description' => $request->desc,
            'date_transaction' => $request->date_transaction,
            'nominal' => $request->nominal,
        ]);

        $tabungan = Tabungan::where('user_id', $request->user_id)->first();
        if ($request->transaction_type == 'Simpanan Wajib') {
            $nominal = Transaksi::where('user_id', $request->user_id)
                                ->where('transaction_type', 'Simpanan Wajib')
                                ->sum('nominal');
            $tabungan->simp_wajib = $nominal;
        } 
        if ($request->transaction_type == 'Simpanan Sukarela') {
            $nominal = Transaksi::where('user_id', $request->user_id)
                                ->where('transaction_type', 'Simpanan Sukarela') 
                                ->sum('nominal');
            $tabungan->simp_sukarela = $nominal;
        }
        $tabungan->save();

        return response()->json([
            'message' => 'Transaksi telah ditambahkan',
            'transaksi' => $transaksi,
            'tabungan' => $tabungan
        ], 200);
    }

    public function updateSimpanan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'transaction_type' => 'required|string|max:255',
            'desc' => 'required|string|max:255',
            'date_transaction' => 'required|date',
            'nominal' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi not found'], 404);
        }

        $data = [
            'user_id' => $request->user_id,
            'transaction_type' => $request->transaction_type,
            'description' => $request->desc,
            'date_transaction' => $request->date_transaction,
            'nominal' => $request->nominal,
        ];

        $transaksi->update($data);

        $tabungan = Tabungan::where('user_id', $request->user_id)->first();
        if ($request->transaction_type == 'Simpanan Wajib') {
            $nominal = Transaksi::where('user_id', $request->user_id)
                                ->where('transaction_type', 'Simpanan Wajib')
                                ->sum('nominal');
            $tabungan->simp_wajib = $nominal;
        } 
        if ($request->transaction_type == 'Simpanan Sukarela') {
            $nominal = Transaksi::where('user_id', $request->user_id)
                                ->where('transaction_type', 'Simpanan Sukarela') 
                                ->sum('nominal');
            $tabungan->simp_sukarela = $nominal;
        }
        $tabungan->save();

        return response()->json([
            'message' => 'Simpanan telah dirubah!',
            'transaksi' => $transaksi
        ], 200);
    }

    public function transaksiById($id)
    {
        $transaksi = Transaksi::find($id);

        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi not found'], 404);
        }
        $data = [
            'id' => $transaksi->id,
            'user_id' => $transaksi->user_id,
            'name' => $transaksi->user->name,
            'transaction_type' => $transaksi->transaction_type,
            'nominal' => $transaksi->nominal,
            'date_transaction' => $transaksi->date_transaction,
            'description' => $transaksi->description
        ];
        return response()->json($data);
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
                              ->where('transaction_type', 'Simpanan Wajib')
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
                              ->where('transaction_type', 'Simpanan Wajib')
                              ->get();

        $transaksi->each(function ($item) {
            $date = new \DateTime($item->date_transaction);
            $item->bulan_simpanan = $date->format('F');
        });

        return response()->json($transaksi);
    }

    public function SumTransaksiSimpananBulananByUserId($id)
    {
        $SimpananWajibLast = Tabungan::where('user_id', $id)->first()->simp_pokok;
        $SimpananWajibTemp = Transaksi::where('user_id', $id)
                        ->where('transaction_type', 'Simpanan Wajib')
                        ->sum('nominal');
        $totalSimpananWajib = $SimpananWajibLast + $SimpananWajibTemp;
        return response()->json(['SimpananBulanan' => $totalSimpananWajib]);
    }

    public function SumTransaksiSimpananBulananByUserLogged()
    {
        $User = Auth::user();
        $SimpananWajibLast = Tabungan::where('user_id', $User->id)->first()->simp_pokok;
        $SimpananWajibTemp = Transaksi::where('user_id', $User->id)
                        ->where('transaction_type', 'Simpanan Wajib')
                        ->sum('nominal');
        $totalSimpananWajib = $SimpananWajibLast + $SimpananWajibTemp;
        return response()->json(['SimpananBulanan' => $totalSimpananWajib]);
    }

    public function SumTransaksiSimpananAkhirByUserId($id)
    {
        $SimpananWajibLast = Tabungan::where('user_id', $id)->first()->simp_pokok; //Simpanan Wajib Terakhir
        $SimpananWajib = Transaksi::where('user_id', $id)
                        ->where('transaction_type', 'Simpanan Wajib')
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
        $SimpananWajibLast = Tabungan::where('user_id', $id)->first()->simp_pokok; //Simpanan Wajib Terakhir
        $SimpananWajib = Transaksi::where('user_id', $id)
                        ->where('transaction_type', 'Simpanan Wajib')
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
        $SimpananWajibLast = Tabungan::where('user_id', $id)->first()->simp_pokok; //Simpanan Wajib Terakhir
        $SimpananWajib = Transaksi::where('user_id', $id)
                        ->where('transaction_type', 'Simpanan Wajib')
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



    public function deleteSimpanan($id)
    {
        $simpanan = Transaksi::findOrFail($id);
        $transaction_type = $simpanan->transaction_type;
        $user_id = $simpanan->user_id;
        $simpanan->delete();
        if ($transaction_type == 'Simpanan Wajib') {
            $nominal = Transaksi::where('user_id', $user_id)
                                ->where('transaction_type', 'Simpanan Wajib')
                                ->sum('nominal');
            $tabungan = Tabungan::where('user_id', $user_id)->first();
            $tabungan->simp_wajib = $nominal;
        }
        if ($transaction_type == 'Simpanan Sukarela') {
            $nominal = Transaksi::where('user_id', $user_id)
                                ->where('transaction_type', 'Simpanan Sukarela')
                                ->sum('nominal');
            $tabungan = Tabungan::where('user_id', $user_id)->first();
            $tabungan->simp_sukarela = $nominal;
        }
        $tabungan->save();
        return response()->json(['message' => 'Simpanan deleted successfully']);
    }

    public function exportSimpanan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'format' => 'required|in:xlsx,csv,pdf'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Query data transaksi sesuai filter yang diberikan
        $query = Transaksi::orderBy('created_at', 'desc');

        if ($request->has('filterAnggota') && $request->filterAnggota != '*') {
            $query->where('user_id', $request->filterAnggota);
        }

        if ($request->has('filterTipeTransaksi') && $request->filterTipeTransaksi != '*') {
            $query->where('transaction_type', $request->filterTipeTransaksi);
        }

        $tahun = null;

        if ($request->has('filterTahun') && $request->filterTahun != '*') {
            $tahun = $request->filterTahun;
        }

        $transactions = $query->get();

        // Tentukan format ekspor
        $format = $request->format;

        // Definisikan nama file dengan ekstensi berdasarkan format
        $filename = 'transactions_' . date('YmdHis') . '.' . $format;

        // Ekspor data sesuai format yang dipilih
        return Excel::download(new TransaksiExport($transactions, $tahun), $filename);
    }

    public function importForm()
    {
        return view('import'); // Provide a view with a form for uploading files
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv'
        ]);

        Excel::import(new TransaksiImport, $request->file('file'));

        return Redirect::back()->with('success', 'Data imported successfully.');
    }

}



