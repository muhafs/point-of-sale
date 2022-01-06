<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:users_read')->only('index');
        $this->middleware('permission:users_create')->only('create');
        $this->middleware('permission:users_update')->only('edit');
        $this->middleware('permission:users_delete')->only('destroy');
    }

    public function index()
    {
        $users = User::whereRoleIs('admin')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
        ]);

        $validated = $request->except(['password', 'password_confirmation', 'permissions']);
        $validated['password'] = bcrypt($request->password);

        $user = User::create($validated);
        $user->attachRole('admin');
        $user->syncPermissions($request->permissions);

        return redirect('users')->with('success', 'Admin has been added successfully');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => "required|unique:users,email,{$user->id}",
        ]);

        $validated = $request->except('permissions');

        $user->update($validated);
        $user->syncPermissions($request->permissions);

        return redirect('users')->with('success', 'Admin has been updated successfully');
    }

    public function destroy(User $user)
    {
        //
    }
}
