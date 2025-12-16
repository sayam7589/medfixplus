<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
Use Alert;

class UserPermissionController extends Controller
{
    public function __construct()
    {
        // examples:
        $this->middleware(['role:superadmin']);
    }
    public function index()
    {
        $roles = Role::all();
        $users = User::all();
        return view('users.permission_index', compact('users', 'roles'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('users.permission', compact('user', 'roles', 'permissions'));
    }

    public function update(Request $request, User $user)
    {
        $user->syncRoles($request->roles);
        $user->syncPermissions($request->permissions);
        return redirect()->route('users.permissions.edit', $user)->with('success', 'Permissions updated successfully.');
    }
}
