<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $totalUsers = \App\Models\User::all()->count();
        $roles = \Spatie\Permission\Models\Role::all();
        return view('admin.usermanager.index', compact('totalUsers', 'roles'));
    }

    public function getUsers(Request $request): JsonResponse
    {
        $roles = $request->roles;
        $users = \App\Models\User::with('roles')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->when($roles, function ($query) use ($roles) {
                return $query->where('model_has_roles.role_id', $roles);
            })
            ->latest();

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function ($users) {
                return
                    '
                    <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" title="More..."></button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><span class="mx-3" id="edit-user" data-id="' . $users->id . '" data-name="' . e($users->username) . '" style="cursor: pointer; color: #007bff;">Edit</span></li>
                            <li><span class="mx-3" id="delete-user" data-toggle="modal" data-target="#deleteModal"  data-id="' . $users->id . '" data-name="' . e($users->username) . '" style="cursor: pointer; color: #007bff;">Delete</span></li>
                        </ul>
                    </div>
                    '
                    ;
            })
            ->make();
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'fullname' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|string|email|max:50|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'role' => 'required|string|exists:roles,name',
        ]);

        // Penanganan upload gambar
        $file_path = null;
        if ($request->hasFile('avatar')) {
            $file_path = $request->file('avatar')->store('avatar', 'public');
        }

        $user = \App\Models\User::create([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'avatar' => $file_path,
        ]);

        $user->assignRole($request->role);

        return response()->json([
            'message' => 'Data berhasil disimpan.'
        ]);
    }

    public function edit($id): JsonResponse
    {
        $user = \App\Models\User::with(['roles' => function ($query) {
            $query->select('id', 'name');
        }])->findOrFail($id);
        return response()->json($user);
    }

    public function delete($id): JsonResponse
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();
        // tambahkan fungsi delete avatar jika ada
        if ($user->avatar) {
            \Storage::disk('public')->delete($user->avatar);
        }
        return response()->json([
            'message' => 'User berhasil dihapus.'
        ]);
    }

    public function profil($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('admin.userprofil', compact('user'));
    }
}
