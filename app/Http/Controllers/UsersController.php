<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('dashboard.pages.users', compact('users'));
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
        $user = new User;
        $user->username = $request->username;
        $user->password = hash::make($request->password);
        $user->role = $request->role;
        $user->num_member = $request->num_member;
        $user->save();
        return response()->json($user);
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
