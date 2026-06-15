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
        $request->validate([
            'roles' => 'nullable|array',
            'permissions' => 'nullable|array',
        ]);

        // กัน error กรณีไม่ติ๊ก checkbox ใดเลย (เดิม syncRoles(null) จะ throw)
        $user->syncRoles($request->roles ?? []);

        // sync permissions เฉพาะเมื่อฟอร์มส่งมา (ฟอร์มปัจจุบันมีแค่ roles)
        if ($request->has('permissions')) {
            $user->syncPermissions($request->permissions);
        }

        // เดิมใช้ ->with('success') ซึ่งไม่ถูกแสดงผล (ระบบใช้ SweetAlert) → ไม่มีแจ้งเตือนหลังบันทึก
        toast('บันทึกสิทธิ์การใช้งานเรียบร้อยแล้ว', 'success');
        return redirect()->route('users.permissions.edit', $user);
    }
}
