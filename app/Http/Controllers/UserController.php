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
        return view('admin.settings.usermanager.index', compact('totalUsers', 'roles'));
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
            ->addColumn('foto', function ($users) {
                if ($users->avatar) {
                    return '<img src="' . asset('storage/' . $users->avatar) . '" alt="Avatar" class="img-circle" width="40" height="40">';
                }
                return '<img src="' . asset('storage/avatar/default-avatar.jpg') . '" alt="Avatar" class="img-circle" width="40" height="40">';
            })
            ->addColumn('role', function ($users) {
                return $users->roles->pluck('name')->map(function ($role) {
                    return ucwords(str_replace('_', ' ', $role));
                })->implode(', ');
            })
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
            'role' => 'required|array|min:1',
            'role.*' => 'string|exists:roles,name',
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

        $user->syncRoles($request->role);

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

    public function update(Request $request, $id): JsonResponse
    {
        $user = \App\Models\User::findOrFail($id);

        $request->validate([
            'fullname' => 'required|string|max:100',
            'email' => 'required|string|email|max:50|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'role' => 'required|array|min:1',
            'role.*' => 'string|exists:roles,name',
        ]);

        $data = [
            'fullname' => $request->fullname,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                \Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatar', 'public');
        }

        $user->update($data);
        $user->syncRoles($request->role);

        return response()->json(['message' => 'User berhasil diperbarui.']);
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

    /**
     * Tampilkan halaman profile user yang sedang login.
     */
    public function profile(): View
    {
        $user = auth()->user();
        $user->load('roles');
        return view('admin.settings.usermanager.userprofil', compact('user'));
    }

    /**
     * Update profile data (fullname, email, mobile, address, title).
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $user = auth()->user();

        $request->validate([
            'fullname' => 'required|string|max:100',
            'email' => 'required|string|email|max:50|unique:users,email,' . $user->id,
            'mobile' => 'nullable|string|max:64',
            'address' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:64',
        ]);

        $user->update($request->only(['fullname', 'email', 'mobile', 'address', 'title']));

        return response()->json(['message' => 'Profile berhasil diperbarui.']);
    }

    /**
     * Update password user yang sedang login.
     */
    public function updatePassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = auth()->user();

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return response()->json(['errors' => ['current_password' => ['Password saat ini salah.']]], 422);
        }

        $user->update(['password' => bcrypt($request->new_password)]);

        return response()->json(['message' => 'Password berhasil diperbarui.']);
    }

    /**
     * Upload avatar untuk user yang sedang login.
     */
    public function updateAvatar(Request $request): JsonResponse
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'avatar.required' => 'File avatar wajib diupload.',
            'avatar.image' => 'File harus berupa gambar.',
            'avatar.mimes' => 'Format gambar harus jpeg, jpg, atau png.',
            'avatar.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $user = auth()->user();

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatar', 'public');
            $user->update(['avatar' => $path]);
        }

        $avatarUrl = $user->avatar
            ? asset('storage/' . $user->avatar)
            : asset('assets/dist/img/user1-128x128.jpg');

        return response()->json([
            'message' => 'Avatar berhasil diperbarui.',
            'avatar_url' => $avatarUrl,
        ]);
    }
}
