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
        return view('admin.issues.index' , compact('issues'));
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
