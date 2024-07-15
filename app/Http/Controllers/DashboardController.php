<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(){
    if (Auth::check()) {
        if (Auth::user()->role->name === 'Member') {
            return redirect()->intended('/profile');
        }
    }
        return view('dashboard.pages.dashboard');
    }
}
