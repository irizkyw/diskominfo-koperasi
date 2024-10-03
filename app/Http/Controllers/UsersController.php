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
        $title = "Dashboard - Kelola Anggota";

        $users = User::orderBy("status_active", "desc")
            ->orderBy("created_at", "desc")
            ->get();

        $roles = Role::all();
        $golongan = Golongan::all();

        return view(
            "dashboard.pages.users",
            compact("users", "roles", "golongan" , 'title')
        );
    }

    public function datatable()
    {
        $query = User::with("role")->withTrashed()->get();

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn("role", function ($row) {
                return $row->role->name;
            })
            ->editColumn("num_member", function ($row) {
                return str_pad($row->num_member, 3, "0", STR_PAD_LEFT);
            })
            ->addColumn("status", function ($row) {
                if ($row->status_active) {
                    return '<div class="badge badge-light-success">Anggota</div>';
                } else {
                    return '<div class="badge badge-light-danger">Tidak Aktif</div>';
                }
            })
            ->editColumn("created_at", function ($row) {
                return $row->created_at->format("d M Y, h:i a");
            })
            ->addColumn("actions", function ($row) {
                $restoreUrl = route("users.restore", [
                    "num_member" => $row->num_member,
                ]);
                $actionButton =
                    '<a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 user-edit"
                                data-id="' .
                    $row->num_member .
                    '">
                                <span class="svg-icon svg-icon-2">
                                    <i class="fas fa-pen"></i>
                                </span>
                            </a>';

                if ($row->status_active) {
                    $actionButton .=
                        '
                        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 user-delete"
                        data-id="' .
                        $row->num_member .
                        '">
                        <span class="svg-icon svg-icon-2">
                            <i class="fas fa-trash"></i>
                        </span>
                    </a>';
                } else {
                    $actionButton .=
                        '
                        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 user-restore"
                        data-id="' .
                        $row->num_member .
                        '">
                        <span class="svg-icon svg-icon-2">
                            <i class="fas fa-undo"></i>
                        </span>
                    </a>';
                }

                $actionButton .=
                    '
                    <a href="' .
                    route("profile", ["user_id" => $row->id]) .
                    '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm">
                        <span class="svg-icon svg-icon-2">
                            <i class="fas fa-user"></i>
                        </span>
                    </a>';

                return '
                    <div class="d-flex justify-content-end">
                        ' .
                    $actionButton .
                    '
                    </div>';
            })

            ->rawColumns(["status", "actions"])
            ->make(true);
    }

    public function getNewMemberNumber()
    {
        $lastMember = User::withTrashed()
            ->orderBy("num_member", "desc")
            ->first();

        $newNumber = $lastMember ? $lastMember->num_member + 1 : 1;

        return response()->json(["newNumber" => $newNumber]);
    }

    public function cekUserByNumMember($num_member)
    {
        $user = User::withTrashed()->where("num_member", $num_member)->first();
        if (!$user) {
            return response()->json(["message" => "User not found."], 404);
        }
        $user = $user->load("savings");
        $data = [
            "id" => $user->id,
            "num_member" => $user->num_member,
            "username" => $user->username,
            "name" => $user->name,
            "golongan" => $user->golongan_id ?? null,
            "role_id" => $user->role_id,
            "status_active" => $user->status_active,
        ];
        return response()->json($data);
    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:255",
            "num_member" => "required|string|max:255",
            "roles" => "required",
            "group" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    "errors" => $validator->errors(),
                ],
                422
            );
        }

        // Generate a unique username
        $generateUniqueUsername = function ($name, $num_member) {
            do {
                $words = explode(" ", $name);
                $firstName = strtolower($words[0]);
                $username =
                    $firstName . str_pad($num_member, 3, "0", STR_PAD_LEFT);
                $userExists = User::where("username", $username)->exists();
            } while ($userExists);

            return $username;
        };

        $username = $generateUniqueUsername(
            $request->name,
            $request->num_member
        );

        // Create the new user
        $user = User::create([
            "name" => $request->name,
            "num_member" => $request->num_member,
            "username" => $username,
            "password" => Hash::make($username),
            "role_id" => $request->roles,
            "status_active" => true,
            "golongan_id" => $request->group,
        ]);

        if ($user) {
            $currentYear = Carbon::now()->format("Y");

            $tabungan = Tabungan::where("user_id", $user->id)
                ->where("tabungan_tahun", $currentYear)
                ->first();

            if (!$tabungan) {
                $tabungan = Tabungan::create([
                    "user_id" => $user->id,
                    "simp_sukarela" => $request->voluntary_savings ?? 0,
                    "simp_wajib" => $request->mandatory_savings ?? 0,
                    "simp_pokok" => 0,
                    "tabungan_tahun" => $currentYear,
                ]);
            }

            if ($request->voluntary_savings != 0) {
                $requestSimpanan = new Request([
                    "user_id" => $user->id,
                    "transaction_type" => "Simpanan Sukarela",
                    "desc" =>
                        "Pendaftaran anggota baru dengan membayar Simpanan Sukarela untuk bulan " .
                        Carbon::now()->format("F") .
                        ".",
                    "nominal" => $request->voluntary_savings,
                    "date_transaction" => now()->format("Y-m-d"),
                ]);

                $transaksiController = new TransaksiController();
                $transaksiController->createSimpanan($requestSimpanan);
            }

            if ($request->mandatory_savings != 0) {
                $requestSimpanan = new Request([
                    "user_id" => $user->id,
                    "transaction_type" => "Simpanan Pokok",
                    "desc" =>
                        "Pendaftaran anggota baru dengan membayar Simpanan Pokok untuk bulan " .
                        Carbon::now()->format("F") .
                        ".",
                    "nominal" => $request->mandatory_savings,
                    "date_transaction" => now()->format("Y-m-d"),
                ]);

                $transaksiController = new TransaksiController();
                $transaksiController->createSimpanan($requestSimpanan);
            }
        }

        $user = $user->load("role");

        return response()->json(
            [
                "message" => "Data telah ditambahkan",
                "user" => $user,
            ],
            200
        );
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::where("num_member", $id)->first();
        if (!$user) {
            return response()->json(["message" => "User not found"], 404);
        }

        $data = [
            "name" => $request->name,
            "username" => $request->username,
            "role_id" => $request->roles,
            "status_active" => $request->status,
            "golongan_id" => $request->group,
        ];

        if (!empty($request->password)) {
            $data["password"] = Hash::make($request->password);
        }

        User::where("num_member", $id)->update($data);

        $user = User::where("num_member", $id)->first();

        $tabungan = Tabungan::where("user_id", $user->id)->first();

        $isSimpWajibChanged =
            $request->has("simp_wajib") &&
            $request->simp_wajib != $tabungan->simp_wajib;
        $isGroupChanged =
            $request->has("group") && $request->group != $tabungan->golongan_id;

        if ($isSimpWajibChanged || $isGroupChanged) {
            $newGolongan = Golongan::find($request->group);
            $tabungan->update([
                "simp_sukarela" => $tabungan->simp_sukarela,
                "simp_wajib" => $request->simp_wajib ?? $tabungan->simp_wajib,
                "golongan_id" => $request->group,
                "simp_pokok" => $newGolongan->simp_pokok,
            ]);
        }

        if ($isGroupChanged) {
            $transaksi = Transaksi::where("user_id", $user->id)
                ->where("transaction_type", "Simpanan Pokok")
                ->first();

            $transactionData = [
                "user_id" => $user->id,
                "transaction_type" => "Simpanan Pokok",
                "description" =>
                    "Perubahan golongan ke " .
                    $newGolongan->nama_golongan .
                    " pada " .
                    Carbon::now()->format("F Y") .
                    ".",
                "nominal" => $newGolongan->simp_pokok,
                "date_transaction" => now()->format("Y-m-d"),
            ];

            if ($transaksi) {
                $transaksi->update($transactionData);
            } else {
                Transaksi::create($transactionData);
            }
        }

        return response()->json([
            "message" => "Data user telah diubah",
            "user" => $user,
        ]);
    }

    public function deleteUser($num_member)
    {
        if ($num_member == 0) {
            return response()->json(["message" => "Invalid user number."], 400);
        }

        $user = User::where("num_member", $num_member)->first();

        if (!$user) {
            return response()->json(["message" => "User not found."], 404);
        }

        $user->delete();
        $user->update(["status_active" => false]);

        return response()->json(["message" => "User deleted successfully."]);
    }

    public function forceDeleteUser($num_member)
    {
        if ($num_member == 0) {
            return response()->json(["message" => "Invalid user number."], 400);
        }

        $user = User::withTrashed()->where("num_member", $num_member)->first();

        if (!$user) {
            return response()->json(["message" => "User not found."], 404);
        }

        $user->savings()->delete();
        $user->transactions()->delete();
        $user->forceDelete();

        return response()->json([
            "message" => "User permanently deleted successfully.",
        ]);
    }

    public function restoreUser($num_member)
    {
        $user = User::withTrashed()->where("num_member", $num_member)->first();

        if (!$user) {
            return response()->json(["message" => "User not found."], 404);
        }

        $user->restore();
        $user->update(["status_active" => true]);
        return response()->json(["message" => "User restored successfully."]);
    }
}
