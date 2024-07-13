<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Role;
use App\Models\Golongan;
use Yajra\DataTables\DataTables;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        $users = User::latest()->get();
        $roles = Role::all();
        $golongan = Golongan::all();

        return view('dashboard.pages.users', compact('users','roles','golongan'));
    }

    public function datatable()
    {
        $query = User::get();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('role', function($row) {
                return $row->role->name;
            })
            ->editColumn('num_member', function($row) {
                return str_pad($row->num_member, 3, '0', STR_PAD_LEFT);
            })
            ->addColumn('status', function($row) {
                if ($row->status_active)
                    return '<div class="badge badge-light-success">Anggota</div>';
                else
                    return '<div class="badge badge-light-danger">Tidak Aktif</div>';
            })
            ->editColumn('created_at', function($row) {
                return $row->created_at->format('d M Y, h:i a');
            })
            ->addColumn('actions', function($row) {
                return '
                <div class="d-flex justify-content-end">
                <a href="#"
                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 user-edit"
                    data-id="'. $row->num_member .'">
                    <span class="svg-icon svg-icon-2">
                        <i class="fas fa-pen"></i>
                    </span>
                </a>
                <a href="#"
                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 user-delete"
                    data-id="'. $row->num_member .'">
                    <span class="svg-icon svg-icon-2">
                        <i class="fas fa-trash"></i>
                    </span>
                </a>
                <a href="#"
                    class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                    <span class="svg-icon svg-icon-2">
                        <i class="fas fa-user"></i>
                    </span>
                </a>
            </div>';
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    public function getNewMemberNumber()
    {
        $lastMember = User::orderBy('num_member', 'desc')->first();
        $newNumber = $lastMember ? $lastMember->num_member + 1 : 1;

        return response()->json(['newNumber' => $newNumber]);
    }

    public function cekUserById($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function cekUserByNumMember($num_member)
    {
        $user = User::where('num_member', $num_member)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        return response()->json($user);
    }

    public function cekUserBynum_member($num_member)
    {
        $user = User::where('num_member', $num_member)->first();
        return response()->json($user);
    }

    public function cekUserByRole($role)
    {
        $user = User::where('role', $role)->get();
        return response()->json($user);
    }

    public function cekUserByUserName($username)
    {
        $user = User::where('username', $username)->first();
        return response()->json($user);
    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'num_member' => 'required|string|max:255',
            'roles' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $generateUniqueUsername = function ($name) {
            do {
                $words = explode(' ', $name);
                $selectedWord = $words[array_rand($words)];
                $randomPart = Str::random(4);
                $username = ucfirst(Str::slug($selectedWord, '')) . '#' . strtoupper($randomPart);
                $username = substr($username, 0, 16);
                $userExists = User::where('username', $username)->exists();
            } while ($userExists);

            return $username;
        };

        $username = $generateUniqueUsername($request->name);

        $user = User::create([
            'name' => $request->name,
            'num_member' => $request->num_member,
            'username' => $username,
            'password' => Hash::make($username),
            'role_id' => $request->roles,
            'status_active' => true
        ]);

        $user = $user->load('role');

        return response()->json([
            'message' => 'Data telah ditambahakan',
            'user' => $user
        ], 200);
    }



    public function updateUser(Request $request, $id)
    {
        $user = User::where('num_member', $id)->first();
        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'role_id' => $request->roles,
            'status_active' => $request->status,
        ];

        if (!empty($request->password))
            $data['password'] = Hash::make($request->password);

        $user->update($data);
        return response()->json($user);
    }

    public function deleteUser($num_member)
    {
        $user = User::where('num_member', $num_member)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $roleName = $user->role->name;
        if ($roleName === 'Administrator') {
            $adminCount = Role::where('name', 'Administrator')->count();

            if ($adminCount <= 1) {
                return response()->json(['message' => 'Minimal harus ada satu peran Administrator.'], 422);
            }
        }
        $user->delete();

        return response()->json(['message' => 'User deleted successfully.']);
    }

}
