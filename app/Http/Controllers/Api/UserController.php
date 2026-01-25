<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $totalUsers = \App\Models\User::all()->count();
        return view('admin.usermanager', compact('totalUsers'));
    }

    public function getUsers(Request $request): JsonResponse
    {
        $users = \App\Models\User::get();
        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('action', function ($users) {
                return
                    '
                    <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" title="More..."></button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><span class="mx-3" id="edit-klasifikasi" data-id="' . $users->id . '" data-name="' . e($users->name) . '" style="cursor: pointer; color: #007bff;">Edit</span></li>
                            <li><span class="mx-3" id="delete-klasifikasi"  data-id="' . $users->id . '" data-name="' . e($users->name) . '" style="cursor: pointer; color: #007bff;">Delete</span></li>
                        </ul>
                    </div>
                    '
                    ;
            })
            ->make();
    }

    public function fetchUser($id): JsonResponse
    {
        $user = \App\Models\User::findOrFail($id);
        return response()->json($user);
    }

}
