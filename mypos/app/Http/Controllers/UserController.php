<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    //! CONSTRUCTOR
    public function __construct()
    {
        $this->middleware('permission:users_read')->only('index');
        $this->middleware('permission:users_create')->only('create');
        $this->middleware('permission:users_update')->only('edit');
        $this->middleware('permission:users_delete')->only('destroy');
    }

    //! INDEX
    public function index()
    {
        $users = User::whereRoleIs('admin')->get();
        return view('admin.users.index', compact('users'));
    }

    //! CREATE
    public function create()
    {
        return view('admin.users.create');
    }

    //! STORE
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'image' => 'image',
            'password' => 'required|confirmed',
            'permissions' => 'required|min:1',
        ]);

        $validated = $request->except(['password', 'password_confirmation', 'permissions', 'image']);
        $validated['password'] = bcrypt($request->password);

        if ($request->image) {
            //? create instance
            $image = Image::make($request->image);
            //? resize the image to a width of 300 and constrain aspect ratio (auto height)
            $image->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            //? save the same file as jpg with default quality
            $image->save('uploads/users/' . $request->image->hashName());

            $validated['image'] = $image->basename;
        }

        // dd($validated);
        $user = User::create($validated);
        $user->attachRole('admin');
        $user->syncPermissions($request->permissions);

        return redirect('users')->with('success', 'Admin has been added successfully');
    }

    //! EDIT
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    //! UPDATE
    public function update(Request $request, User $user)
    {
        // dd($user->image);
        $request->validate([
            'name' => 'required',
            'email' => "required|unique:users,email,{$user->id}",
            'image' => 'image',
            'permissions' => 'required|min:1',
        ]);

        $validated = $request->except(['permissions', 'image']);


        if ($request->image) {
            //? Delete the stored image
            if ($user->image !== 'default.png') {
                Storage::disk('public_uploads')->delete('/users/' . $user->image);
            }

            //? create instance, the resize the image to a width of 300 and constrain aspect ratio (auto height)
            $image = Image::make($request->image);
            $image->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $image->save('uploads/users/' . $request->image->hashName());

            $validated['image'] = $image->basename;
        }

        $user->update($validated);
        $user->syncPermissions($request->permissions);

        return redirect('users')->with('success', 'Admin has been updated successfully');
    }

    //! DESTROY
    public function destroy(User $user)
    {
        if ($user->image != 'default.png') {
            Storage::disk('public_uploads')->delete('/users/' . $user->image);
        }
        $user->delete();

        return redirect('users')->with('success', 'Admin has been deleted successfully');
    }
}
