<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

use App\Models\Role;
class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        $title = "Dashboard - Posisi Roles";
        return view('dashboard.pages.roles', compact('roles', 'title'));
    }

    public function datatable()
    {
        $query = Role::get();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('id', function($row) {
                return $row->id;
            })
            ->addColumn('name', function($row) {
                return $row->name;
            })
            ->editColumn('desc', function($row) {
                return $row->desc;
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


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
        ]);

        Role::create($request->all());

        return response()->json(['message' => 'Role berhasil dibuat.']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
        ]);

        $role = Role::find($id);
        if ($request->name === 'Administrator') {
            return response()->json(['message' => 'Peran Administrator tidak dapat diubah.'], 422);
        }
        if ($role) {
            $role->update($request->all());
            return response()->json(['message' => 'Role '.$role->name.' berhasil dirubah.']);
        }

        return response()->json(['message' => 'Role tidak ditemukan.'], 404);
    }

    public function findById($id)
    {
        $role = Role::find($id);
        return response()->json($role);
    }

    public function destroy($id)
    {
        $adminCount = Role::where('name', 'Administrator')->count();
        $role = Role::findOrFail($id);
        if ($role->name === 'Administrator') {
            if ($adminCount <= 1) {
                return response()->json(['message' => 'Minimal harus ada satu peran Administrator.'], 422);
            }
        }
        $role->delete();

        return response()->json(['message' => 'Role berhasil dihapus.']);
    }

}
