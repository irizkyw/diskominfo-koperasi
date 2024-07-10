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
        $roles = Role::all();

        $result = [
            'users' => $users,
            '$roles' => $roles
        ];

        return view('dashboard.pages.users', compact('result'));
    }
}
