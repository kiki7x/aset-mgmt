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
use App\Models\AssetsModel;

class LicensesController extends Controller
{
    const TAG_PREFIX = 'ITL';

    public function index(): View
    {
        return view('admin.lisensi.index');
    }

    public function overview($id): View
    {
        $license = LicensesModel::with(['status', 'category', 'supplier'])->findOrFail($id);
        return view('admin.lisensi.detaillicense.ringkasan', compact('id', 'license'));
    }

    public function editDetail($id): View
    {
        $license = LicensesModel::with(['status', 'category', 'supplier'])->findOrFail($id);
        $statuses = LabelsModel::all();
        $categories = LicensecategoriesModel::all();
        $suppliers = SuppliersModel::all();
        return view('admin.lisensi.detaillicense.edit', compact('id', 'license', 'statuses', 'categories', 'suppliers'));
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
                            <li><a class="mx-3" href="' . route('admin.license.edit', $licenses->id) . '" style="cursor: pointer; color: #007bff;">Edit</a></li>
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

    public function getAssignedAssets($id): JsonResponse
    {
        $license = LicensesModel::findOrFail($id);
        $assets = $license->assets()->with(['status', 'category', 'model'])->get();

        return DataTables::of($assets)
            ->addIndexColumn()
            ->addColumn('category', function ($asset) {
                return $asset->category ? $asset->category->name : '-';
            })
            ->addColumn('model', function ($asset) {
                return $asset->model ? $asset->model->name : '-';
            })
            ->addColumn('action', function ($asset) use ($id) {
                return '<button type="button" class="btn btn-danger btn-sm btn-detach-asset" data-asset-id="' . $asset->id . '" data-asset-name="' . e($asset->name) . '"><i class="fas fa-unlink"></i></button>';
            })
            ->rawColumns(['action'])
            ->make();
    }

    public function availableAssets(Request $request, $id): JsonResponse
    {
        $license = LicensesModel::findOrFail($id);
        $assignedIds = $license->assets()->pluck('assets.id');

        $assets = AssetsModel::with(['status', 'category'])
            ->whereNotIn('assets.id', $assignedIds);

        return DataTables::of($assets)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($asset) {
                return '<input type="checkbox" class="asset-checkbox" value="' . $asset->id . '">';
            })
            ->addColumn('status', function ($asset) {
                return $asset->status ? $asset->status->name : '-';
            })
            ->addColumn('category', function ($asset) {
                return $asset->category ? $asset->category->name : '-';
            })
            ->rawColumns(['checkbox'])
            ->make();
    }

    public function select2Assets(Request $request, $id): JsonResponse
    {
        $license = LicensesModel::findOrFail($id);
        $assignedIds = $license->assets()->pluck('assets.id');

        $query = AssetsModel::whereNotIn('assets.id', $assignedIds);

        if ($search = $request->q) {
            $query->where(function ($q) use ($search) {
                $q->where('tag', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('serial', 'like', "%{$search}%");
            });
        }

        $assets = $query->limit(50)->get();

        $results = $assets->map(function ($asset) {
            $text = $asset->tag . ' - ' . $asset->name;
            if ($asset->serial) {
                $text .= ' (' . $asset->serial . ')';
            }
            return [
                'id' => $asset->id,
                'text' => $text,
            ];
        });

        return response()->json(['results' => $results]);
    }

    public function attachAsset(Request $request, $id): JsonResponse
    {
        $request->validate([
            'asset_ids' => 'required|array',
            'asset_ids.*' => 'exists:assets,id',
        ]);

        $license = LicensesModel::findOrFail($id);
        $license->assets()->syncWithoutDetaching($request->asset_ids);

        return response()->json(['message' => 'Aset berhasil ditambahkan ke lisensi.']);
    }

    public function detachAsset($id, $assetId): JsonResponse
    {
        $license = LicensesModel::findOrFail($id);
        $license->assets()->detach($assetId);

        return response()->json(['message' => 'Aset berhasil dihapus dari lisensi.']);
    }

}
