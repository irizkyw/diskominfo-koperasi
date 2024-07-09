<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminContoller extends Controller
{
    public function cekSemuaUser()
    {
        $user = User::all();
        return response()->json($user);
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



}
