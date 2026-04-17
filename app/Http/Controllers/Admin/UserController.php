<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

public function index()
{
    $users = User::whereHas('role', function ($q) {
        $q->where('nama_role', 'pemilik_course');
    })->get();

    return view('admin.users.index', compact('users'));
}

public function create()
{
    return view('admin.users.create');
}

public function store(Request $request)
{
    $role = Role::where('nama_role', 'pemilik_course')->first();

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role_id' => $role->id,
    ]);

    return redirect('/admin/users');
}

public function toggle($id)
{
    $user = User::findOrFail($id);
    $user->is_active = !$user->is_active;
    $user->save();

    return back();
}
}
