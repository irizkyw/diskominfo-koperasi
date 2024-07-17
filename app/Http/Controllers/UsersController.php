<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Role;
use App\Models\Golongan;
use App\Models\Tabungan;
use App\Models\Transaksi;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\TabunganController;
use App\Http\Controllers\TransaksiController;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('status_active', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $roles = Role::all();
        $golongan = Golongan::all();

        return view('dashboard.pages.users', compact('users', 'roles', 'golongan'));
    }

    public function datatable()
    {
        $query = User::with('role')->withTrashed()->get();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('role', function ($row) {
                return $row->role->name;
            })
            ->editColumn('num_member', function ($row) {
                return str_pad($row->num_member, 3, '0', STR_PAD_LEFT);
            })
            ->addColumn('status', function ($row) {
                if ($row->status_active) {
                    return '<div class="badge badge-light-success">Anggota</div>';
                } else {
                    return '<div class="badge badge-light-danger">Tidak Aktif</div>';
                }
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('d M Y, h:i a');
            })
            ->addColumn('actions', function ($row) {
                $restoreUrl = route('users.restore', ['num_member' => $row->num_member]);
                $actionButton = '<a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 user-edit"
                                data-id="' . $row->num_member . '">
                                <span class="svg-icon svg-icon-2">
                                    <i class="fas fa-pen"></i>
                                </span>
                            </a>';

                if ($row->status_active) {
                    // User is active
                    $actionButton .= '
                        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 user-delete"
                        data-id="' . $row->num_member . '">
                        <span class="svg-icon svg-icon-2">
                            <i class="fas fa-trash"></i>
                        </span>
                    </a>';
                } else {
                    // User is inactive
                    $actionButton .= '
                        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 user-restore"
                        data-id="' . $row->num_member . '">
                        <span class="svg-icon svg-icon-2">
                            <i class="fas fa-undo"></i>
                        </span>
                    </a>';
                }

                // Common action for both active and inactive users
                $actionButton .= '
                    <a href="'. route('profile', ['user_id' => $row->id]) .'" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                        <span class="svg-icon svg-icon-2">
                            <i class="fas fa-user"></i>
                        </span>
                    </a>';

                return '
                    <div class="d-flex justify-content-end">
                        ' . $actionButton . '
                    </div>';
            })

            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    public function getNewMemberNumber()
    {
        $lastMember = User::withTrashed()
            ->orderBy('num_member', 'desc')
            ->first();

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
        $user = User::withTrashed()->where('num_member', $num_member)->first();

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
            'roles' => 'required',
            'group' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
        $generateUniqueUsername = function ($name, $num_member) {
            do {
                $words = explode(' ', $name);
                $firstName = strtolower($words[0]);
                $username = $firstName . str_pad($num_member, 3, '0', STR_PAD_LEFT);
                $userExists = User::where('username', $username)->exists();
            } while ($userExists);

            return $username;
        };
        $username = $generateUniqueUsername($request->name, $request->num_member);
        $user = User::create([
            'name' => $request->name,
            'num_member' => $request->num_member,
            'username' => $username,
            'password' => Hash::make($username), // Gunakan username sebagai password sementara
            'role_id' => $request->roles,
            'status_active' => true
        ]);
        if ($user) {
            $tabunganController = new TabunganController();
            $transaksiController = new TransaksiController();
            if ($request->voluntary_savings != 0) {
                $requestSimpanan = new Request([
                    'user_id' => $user->id,
                    'transaction_type' => 'Simpanan Sukarela',
                    'desc' => 'Pendaftaran anggota baru dengan membayar Simpanan Sukarela untuk bulan ' . Carbon::now()->format('F') . '.',
                    'nominal' => $request->voluntary_savings,
                    'date_transaction' => now()->format('Y-m-d')
                ]);

                $transaksiController->createSimpanan($requestSimpanan);
            }

            if ($request->mandatory_savings != 0) {
                $requestSimpanan = new Request([
                    'user_id' => $user->id,
                    'transaction_type' => 'Simpanan Pokok',
                    'desc' => 'Pendaftaran anggota baru dengan membayar Simpanan Pokok untuk bulan ' . Carbon::now()->format('F') . '.',
                    'nominal' => $request->mandatory_savings,
                    'date_transaction' => now()->format('Y-m-d')
                ]);

                $transaksiController->createSimpanan($requestSimpanan);
            }

            $requestTabungan = new Request([
                'user_id' => $user->id,
                'simp_sukarela' => $request->voluntary_savings,
                'simp_wajib' => $request->mandatory_savings,
                'golongan_id' => $request->group,
            ]);

            $tabunganController->createTabungan($requestTabungan);

        }
        $user = $user->load('role');

        return response()->json([
            'message' => 'Data telah ditambahkan',
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
        if ($num_member == 0) {
            return response()->json(['message' => 'Invalid user number.'], 400);
        }

        $user = User::where('num_member', $num_member)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $user->delete();
        $user->update(['status_active' => false]);

        return response()->json(['message' => 'User deleted successfully.']);
    }

    public function forceDeleteUser($num_member)
    {
        if ($num_member == 0) {
            return response()->json(['message' => 'Invalid user number.'], 400);
        }

        $user = User::withTrashed()->where('num_member', $num_member)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $user->savings()->delete();
        $user->transactions()->delete();
        $user->forceDelete();

        return response()->json(['message' => 'User permanently deleted successfully.']);
    }



    public function restoreUser($num_member)
    {
        $user = User::withTrashed()->where('num_member', $num_member)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $user->restore();
        $user->update(['status_active' => true]);
        return response()->json(['message' => 'User restored successfully.']);
    }

}
