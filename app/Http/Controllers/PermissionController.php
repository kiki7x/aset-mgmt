<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    public function index(): View
    {
        $roles = Role::withCount('users', 'permissions')->get();
        $permissions = Permission::all()->groupBy(function ($p) {
            return substr($p->name, 0, strrpos($p->name, '-'));
        });
        return view('admin.settings.permission.index', compact('roles', 'permissions'));
    }

    public function getRoles(): JsonResponse
    {
        $roles = Role::withCount('users', 'permissions')->get();
        return response()->json(['data' => $roles]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name',
        ]);

        $role = Role::create(['name' => Str::slug($request->name)]);

        return response()->json(['message' => 'Role berhasil ditambahkan.', 'data' => $role]);
    }

    public function edit($id): JsonResponse
    {
        $role = Role::with('permissions')->findOrFail($id);
        return response()->json([
            'role' => $role,
            'permissionIds' => $role->permissions->pluck('id'),
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $role = Role::findOrFail($id);

        if ($request->has('permissions')) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
            return response()->json(['message' => 'Permission berhasil diperbarui.']);
        }

        $request->validate([
            'name' => 'required|string|max:50|unique:roles,name,' . $id,
        ]);

        $role->update(['name' => Str::slug($request->name)]);

        return response()->json(['message' => 'Role berhasil diperbarui.']);
    }

    public function destroy($id): JsonResponse
    {
        $role = Role::findOrFail($id);

        if ($role->name === 'superadmin') {
            return response()->json(['message' => 'Role superadmin tidak dapat dihapus.'], 422);
        }

        if ($role->users()->count() > 0) {
            return response()->json(['message' => 'Role tidak dapat dihapus karena masih memiliki ' . $role->users()->count() . ' pengguna.'], 422);
        }

        $role->delete();

        return response()->json(['message' => 'Role berhasil dihapus.']);
    }
}
