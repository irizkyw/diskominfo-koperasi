<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Role;
use App\Models\Group;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        $users = User::latest()->get();
        $roles = Role::all();
        $groups = Group::all();
        return view('dashboard.pages.users', compact(['users','roles','groups']));
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
        'password' => Hash::make($username . '#' . $request->num_member),
        'role_id' => $request->roles, // Adjust the field name to match the form
    ]);

    $user = $user->load('role');

    return response()->json([
        'message' => 'Pembuatan akun berhasil',
        'user' => $user
    ], 200);
}



    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());
        return response()->json($user);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        return response()->json($user);
    }
}
