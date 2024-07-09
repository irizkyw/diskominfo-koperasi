<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Tabungan;

class TabunganController extends Controller
{
    public function index()
    {
        return view('tabungan.index');
    }

    public function cekTabunganAll()
    {
        $role = Auth::user()->role;
        $tabungan = Tabungan::all();
        return response()->json($tabungan);
    }

    public function cekTabunganByUser()
    {
        $user = Auth::user();
        $tabungan = Tabungan::all();
        return response()->json($tabungan);
    }
}
