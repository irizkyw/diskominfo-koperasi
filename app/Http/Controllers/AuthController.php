<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        $title = "Koperasi Diskominfo Jawabarat - Sign in";
        if (Auth::check()) {
            if (Auth::user()->role->name === "Member") {
                return redirect()->intended("/profile");
            } else {
                return redirect()->intended("/dashboard");
            }
        }
        return view("landing.sign_in", compact('title'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            "username" => "required",
            "password" => "required",
        ]);

        if (
            Auth::attempt([
                "username" => $request->username,
                "password" => $request->password,
            ])
        ) {
            if (Auth::user()->status_active) {
                $request->session()->regenerate();

                if (Auth::user()->role->name === "Member") {
                    return response()->json(
                        [
                            "message" => "You have successfully logged in!",
                            "redirect" => "/profile",
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            "message" => "You have successfully logged in!",
                            "redirect" => "/dashboard",
                        ],
                        200
                    );
                }
            } else {
                Auth::logout();
                return response()->json(
                    [
                        "error" =>
                            "Akun Anda tidak aktif. Silakan hubungi administrator.",
                    ],
                    422
                );
            }
        } else {
            return response()->json(
                [
                    "error" =>
                        "Username atau password yang anda masukan salah!",
                ],
                422
            );
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/");
    }
}
