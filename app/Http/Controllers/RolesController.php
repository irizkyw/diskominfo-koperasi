<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('dashboard.pages.roles', compact('roles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
        ]);

        Role::create($request->all());

        return redirect()->route('dashboard.pages.roles')->with('success', 'Role created successfully.');
    }

    public function show(Role $role)
    {
        return view('roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required',
            'desc' => 'required',
        ]);

        $role->update($request->all());

        return redirect()->route('dashboard.pages.roles')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('dashboard.pages.roles')->with('success', 'Role deleted successfully.');
    }
}
