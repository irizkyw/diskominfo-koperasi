<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Golongan;

use Yajra\DataTables\DataTables;

class GolonganController extends Controller
{
    public function index()
    {
        $golongans = Golongan::all();
        return view('dashboard.pages.golongan', compact('golongans'));
    }

    public function datatable()
    {
        $query = Golongan::get();

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('nama_golongan', function($row) {
                return $row->nama_golongan;
            })
            ->editColumn('desc', function($row) {
                return $row->desc;
            })
            ->editColumn('simp_pokok', function($row) {
                return 'Rp. ' . number_format($row->simp_pokok, 0, ',', '.');
            })
            ->addColumn('actions', function($row) {
                return '
                <div class="d-flex justify-content-end">
                <a href="#"
                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 golongan-edit"
                    data-id="'. $row->id .'" data-name="'.$row->nama_golongan.'">
                    <span class="svg-icon svg-icon-2">
                        <i class="fas fa-pen"></i>
                    </span>
                </a>
                <a href="#"
                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 golongan-delete"
                    data-id="'. $row->id .'" data-name="'.$row->nama_golongan.'">
                    <span class="svg-icon svg-icon-2">
                        <i class="fas fa-trash"></i>
                    </span>
                </a>
            </div>';
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_golongan' => 'required|string|max:32',
            'desc' => 'nullable|string|max:255',
            'simp_pokok' => 'required|integer',
        ]);

        Golongan::create([
            'nama_golongan' => $request->nama_golongan,
            'desc' => $request->desc,
            'simp_pokok' => $request->simp_pokok,
        ]);

        return response()->json(['message' => 'Golongan berhasil dibuat.']);
    }

    public function findById($id)
    {
        $golongan = Golongan::find($id);
        return response()->json($golongan);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_golongan' => 'required|string|max:32',
            'desc' => 'nullable|string|max:255',
            'simp_pokok' => 'required|integer',
        ]);

        $golongan = Golongan::find($id);
        $golongan->update($request->all());

        return response()->json(['message' => 'Golongan berhasil diubah.']);
    }

    public function destroy($id)
    {
        $golongan = Golongan::findOrFail($id);
        $golongan->delete();

        return response()->json(['message' => 'Golongan berhasil dihapus.']);
    }

}
