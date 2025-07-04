<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class IssuesController extends Controller
{
    public function index(): View
    {
        $issues = \App\Models\IssuesModel::get();
        // untuk dropdown
        $users = \App\Models\User::whereHas('roles', function($query) {$query->where('name','!=', 'superadmin');})->get();
        // $users = \App\Models\User::get();
        $assets = \App\Models\AssetsModel::get();
        $projects = \App\Models\ProjectsModel::get();
        return view('admin.issues.index' , compact('issues', 'users', 'assets', 'projects'));
    }

    public function getIssues(Request $request): JsonResponse
    {
        $issues = \App\Models\IssuesModel::get();

        return DataTables::of($issues)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                return '<div>
                    <button class="btn btn-primary" data-id="' . $row->id . '"><i class="fa-regular fa-pen-to-square"></i></button>
                    <button class="btn btn-danger" data-id="' . $row->id . '"><i class="fa-regular fa-trash-can"></i></button>
                    </div>';
            })
            ->make();
    }
}
