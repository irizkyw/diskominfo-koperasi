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
            ->addColumn('name', function($row) {
                return $row->name;
            })
            ->editColumn('desc', function($row) {
                return $row->desc;
            })
            ->editColumn('simp_pokok', function($row) {
                return $row->sim_pokok;
            })
            ->addColumn('actions', function($row) {
                return '
                <div class="d-flex justify-content-end">
                <a href="#"
                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 roles-edit"
                    data-id="'. $row->id .'" data-name="'.$row->name.'">
                    <span class="svg-icon svg-icon-2">
                        <i class="fas fa-pen"></i>
                    </span>
                </a>
                <a href="#"
                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 roles-delete"
                    data-id="'. $row->id .'" data-name="'.$row->name.'">
                    <span class="svg-icon svg-icon-2">
                        <i class="fas fa-trash"></i>
                    </span>
                </a>
            </div>';
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }
    public function create()
    {
        return view('golongans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_golongan' => 'required|string|max:32',
            'desc' => 'nullable|string|max:255',
            'simp_pokok' => 'required|integer',
        ]);

        Golongan::create($request->all());

        return response()->json(['success' => 'Golongan created successfully']);
    }

    public function show(Golongan $golongan)
    {
        return view('golongans.show', compact('golongan'));
    }

    public function edit(Golongan $golongan)
    {
        return view('golongans.edit', compact('golongan'));
    }

    public function update(Request $request, Golongan $golongan)
    {
        $request->validate([
            'nama_golongan' => 'required|string|max:32',
            'desc' => 'nullable|string|max:255',
            'simp_pokok' => 'required|integer',
        ]);

        $golongan->update($request->all());

        return redirect()->route('golongan.index')->with('success', 'Golongan updated successfully');
    }

    public function destroy(Golongan $golongan)
    {
        $golongan->delete();

        return redirect()->route('golongan.index')->with('success', 'Golongan deleted successfully');
    }
}
