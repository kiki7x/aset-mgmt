<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LicensesModel;
use App\Models\LicensecategoriesModel;
use App\Models\SuppliersModel;
use App\Models\LabelsModel;

class LicensesController extends Controller
{
    const TAG_PREFIX = 'ITL';

    public function index(): View
    {
        return view('admin.lisensi.index');
    }

    public function nextTag(): JsonResponse
    {
        $prefix = self::TAG_PREFIX;
        $lastTag = LicensesModel::where('tag', 'like', $prefix . '-%')
            ->orderByRaw("CAST(SUBSTRING_INDEX(tag, '-', -1) AS UNSIGNED) DESC")
            ->first();

        if ($lastTag) {
            $lastNumber = (int) str_replace($prefix . '-', '', $lastTag->tag);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        return response()->json(['tag' => $prefix . '-' . $nextNumber]);
    }

    public function getData(Request $request): JsonResponse
    {
        $licenses = LicensesModel::with(['status', 'category', 'supplier'])->get();
        return DataTables::of($licenses)
            ->addIndexColumn()
            ->addColumn('status', function ($licenses) {
                return $licenses->status ? $licenses->status->name : '-';
            })
            ->addColumn('category', function ($licenses) {
                return $licenses->category ? $licenses->category->name : '-';
            })
            ->addColumn('supplier', function ($licenses) {
                return $licenses->supplier ? $licenses->supplier->name : '-';
            })
            ->addColumn('action', function ($licenses) {
                return '
                    <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" title="More..."></button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><span class="mx-3" id="edit-license" data-id="' . $licenses->id . '" style="cursor: pointer; color: #007bff;">Edit</span></li>
                            <li><span class="mx-3" id="delete-license" data-id="' . $licenses->id . '" data-name="' . e($licenses->name) . '" style="cursor: pointer; color: #007bff;">Delete</span></li>
                        </ul>
                    </div>
                ';
            })
            ->make();
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'status_id' => 'required|exists:labels,id',
            'category_id' => 'required|exists:licensecategories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'seats' => 'required|string|max:5',
            'tag' => 'required|unique:licenses,tag|string|max:255',
            'name' => 'required|string|max:255',
            'serial' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        LicensesModel::Create($data);
        return response()->json(['message' => 'Lisensi berhasil ditambahkan.']);
    }

    public function edit($id): JsonResponse
    {
        $license = LicensesModel::findOrFail($id);
        return response()->json($license);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $license = LicensesModel::findOrFail($id);
        $data = $request->validate([
            'status_id' => 'required|exists:labels,id',
            'category_id' => 'required|exists:licensecategories,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'seats' => 'required|string|max:5',
            'tag' => 'required|unique:licenses,tag,' . $license->id . '|string|max:255',
            'name' => 'required|string|max:255',
            'serial' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        $license->update($data);
        return response()->json(['message' => 'Lisensi berhasil diperbarui.']);
    }

    public function destroy($id): JsonResponse
    {
        $license = LicensesModel::findOrFail($id);
        $license->delete();
        return response()->json(['message' => 'Lisensi ' . $license->name . ' berhasil dihapus.']);
    }

}
