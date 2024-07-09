<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('landing.sign_in');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            return response()->json([
                'message' => 'You have successfully logged in!',
                'redirect' => '/dashboard',
            ], 200);
        } else {
            return response()->json([
                'error' => 'Username atau password yang anda masukan salah!'
            ], 422);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'role' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $num_member = User::max('num_member') + 1;
        $username = $request->name . '@' . $num_member;

        $user = User::create([
            'name' => $request->name,
            'num_member' => $num_member,
            'username' => $username,
            'password' => Hash::make($username . '@' .$num_member),
            'role_id' => $request->role_id,
        ]);

        return response()->json([
            'message' => 'Pembuatan akun berhasil',
            'redirect' => '/dashboard',
        ], 200);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
