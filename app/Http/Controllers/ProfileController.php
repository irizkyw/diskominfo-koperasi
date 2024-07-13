<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $User = User::Auth();
        $Role = Role::find($User->role_id);
        $Golongan = Golongan::find($User->golongan_id);
        $Transaksi = Transaksi::where('user_id', $User->id)->get();
        
        return view('dashboard.pages.profile', compact('User','Role','Golongan'));
    }
}
