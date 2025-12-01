<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SetatributController extends Controller
{
    public function index(): View
    {
        $hitungklasifikasi = \App\Models\AssetclassificationsModel::all()->count();
        $hitungkategori = \App\Models\AssetcategoriesModel::all()->count();
        $hitungmerk = \App\Models\ManufacturersModel::all()->count();
        $hitungmodel = \App\Models\ModelsModel::all()->count();
        $hitungsupplier = \App\Models\SuppliersModel::all()->count();
        $hitunglabel = \App\Models\LabelsModel::all()->count();
        // $kategorilisensi = \App\Models\LicensecategoriesModel::get();
        $hitunglokasi = \App\Models\LocationsModel::all()->count();
        return view('admin.set-atribut.setatribut', compact('hitungklasifikasi', 'hitungkategori', 'hitungmerk', 'hitungmodel', 'hitungsupplier', 'hitunglabel', 'hitunglokasi')
        );
    }

    public function klasifikasi(): View
    {
        return view('admin.set-atribut.setklasifikasi');
    }

    public function getKlasifikasi(Request $request): JsonResponse
    {
        $klasifikasis = \App\Models\AssetclassificationsModel::get();
        $hitungAset = \App\Models\AssetsModel::all()->count();
        return DataTables::of($klasifikasis)
            ->addIndexColumn()
            ->addColumn('action', function ($klasifikasis) {
                return
                    '
                    <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" title="More..."></button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><span class="mx-3" id="edit-klasifikasi" data-id="' . $klasifikasis->id . '" data-name="' . e($klasifikasis->name) . '" style="cursor: pointer; color: #007bff;">Edit</span></li>
                            <li><span class="mx-3" id="delete-klasifikasi"  data-id="' . $klasifikasis->id . '" data-name="' . e($klasifikasis->name) . '" style="cursor: pointer; color: #007bff;">Delete</span></li>
                        </ul>
                    </div>
                    '
                    ;
            })
            ->addColumn('hitungAset', function ($klasifikasis) {
                $hitungAset = \App\Models\AssetsModel::where('classification_id', $klasifikasis->id)->count();
                return $hitungAset;
            })
            ->make();
    }

    public function storeKlasifikasi(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|unique:assetclassifications,name|string|max:255'
        ]);
        $klasifikasi = \App\Models\AssetclassificationsModel::Create($data);

        return response()->json(['message' => 'Klasifikasi berhasil ditambahkan.']);
    }

    public function editKlasifikasi($id): JsonResponse
    {
        $klasifikasi = \App\Models\AssetclassificationsModel::findOrFail($id);
        return response()->json($klasifikasi);
    }

    public function updateKlasifikasi(Request $request, $id): JsonResponse
    {
        $klasifikasi = \App\Models\AssetclassificationsModel::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|unique:assetclassifications,name,' . $klasifikasi->id . '|string|max:255'
        ]);
        $klasifikasi->update($data);

        return response()->json(['message' => 'Klasifikasi berhasil diperbarui.']);
    }

    public function deleteKlasifikasi($id): JsonResponse
    {
        $klasifikasi = \App\Models\AssetclassificationsModel::findOrFail($id);
        $klasifikasi->delete();

        return response()->json(['message' => 'Klasifikasi ' . $klasifikasi->name . ' berhasil dihapus.']);
    }

    public function kategori(): View
    {
        $klasifikasis = \App\Models\AssetclassificationsModel::get();
        return view('admin.set-atribut.setkategori', compact('klasifikasis'));
    }

    public function getKategori(Request $request): JsonResponse
    {
        $kategoris = \App\Models\AssetcategoriesModel::get();
        // $klasifikasis = \App\Models\AssetclassificationsModel::get();
        return DataTables::of($kategoris)
            ->addIndexColumn()
            ->addColumn('action', function ($kategoris) {
                return
                    '
                    <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" title="More..."></button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><span class="mx-3" id="edit-kategori" data-id="' . $kategoris->id . '" data-name="' . e($kategoris->name) . '" style="cursor: pointer; color: #007bff;">Edit</span></li>
                            <li><span class="mx-3" id="delete-kategori" data-toggle="modal" data-target="#deleteModal" data-id="' . $kategoris->id . '" data-name="' . e($kategoris->name) . '" style="cursor: pointer; color: #007bff;">Delete</span></li>
                        </ul>
                    </div>
                    '
                    ;
            })
            ->addColumn('classification_id', function ($kategoris) {
                return $kategoris->classification ? $kategoris->classification->name : 'Tidak ada klasifikasi';
            })
            ->make();
    }

    public function storeKategori(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|unique:assetcategories,name|string|max:255',
            'classification_id' => 'required|exists:assetclassifications,id',
            'color' => 'required|string|max:7'
        ]);
        $kategori = \App\Models\AssetcategoriesModel::Create($data);

        return response()->json(['message' => 'Kategori berhasil ditambahkan.']);
    }

    public function editKategori($id): JsonResponse
    {
        $kategori = \App\Models\AssetcategoriesModel::findOrFail($id);
        return response()->json($kategori);
    }

    public function updateKategori(Request $request, $id): JsonResponse
    {
        $kategori = \App\Models\AssetcategoriesModel::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|unique:assetcategories,name,' . $kategori->id . '|string|max:255',
            'color' => 'required|string|max:7',
            'classification_id' => 'required|exists:assetclassifications,id',
        ]);
        $kategori->update($data);

        return response()->json(['message' => 'Kategori berhasil diperbarui.']);
    }

    public function deleteKategori($id): JsonResponse
    {
        $kategori = \App\Models\AssetcategoriesModel::findOrFail($id);
        $kategori->delete();

        return response()->json(['message' => 'Kategori ' . $kategori->name . ' berhasil dihapus.']);
    }

    public function merk()
    {
        $merks = \App\Models\ManufacturersModel::get();
        return view('admin.set-atribut.setmerk', compact('merks')
        );
    }

    public function getMerk(): JsonResponse
    {
        $merks = \App\Models\ManufacturersModel::get();
        return DataTables::of($merks)
            ->addIndexColumn()
            ->addColumn('action', function ($merks) {
                return
                    '
                    <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" title="More..."></button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><span class="mx-3" id="edit-merk" data-id="' . $merks->id . '" data-name="' . e($merks->name) . '" style="cursor: pointer; color: #007bff;">Edit</span></li>
                            <li><span class="mx-3" id="delete-merk" data-id="' . $merks->id . '" data-name="' . e($merks->name) . '" style="cursor: pointer; color: #007bff;">Delete</span></li>
                        </ul>
                    </div>
                    '
                    ;
            })
            ->make();
    }

    public function storeMerk(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|unique:manufacturers,name|string|max:255'
        ]);
        $merk = \App\Models\ManufacturersModel::Create($data);
        return response()->json(['message' => 'Merk berhasil ditambahkan.']);
    }

    public function editMerk($id): JsonResponse
    {
        $merk = \App\Models\ManufacturersModel::findOrFail($id);
        return response()->json($merk);
    }
    public function updateMerk(Request $request, $id): JsonResponse
    {
        $merk = \App\Models\ManufacturersModel::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|unique:manufacturers,name,' . $merk->id . '|string|max:255',
        ]);
        $merk->update($data);
        return response()->json(['message' => 'Merk berhasil diperbarui.']);
    }

    public function deleteMerk($id): JsonResponse
    {
        $merk = \App\Models\ManufacturersModel::findOrFail($id);
        $merk->delete();

        return response()->json(['message' => 'Merk ' . $merk->name . ' berhasil dihapus.']);
    }

    public function model(): View
    {
        return view('admin.set-atribut.setmodel');
    }

    public function getModel(): JsonResponse
    {
        $models = \App\Models\ModelsModel::get();
        return DataTables::of($models)
        ->addIndexColumn()
        ->addColumn('hitungAset', function ($models) {
            $hitungAset = \App\Models\AssetsModel::where('model_id', $models->id)->count();
            return $hitungAset;
        })
        ->addColumn('action', function ($models) {
            return
            '
                    <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" title="More..."></button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><span class="mx-3" id="edit-model" data-id="' . $models->id . '" data-name="' . e($models->name) . '" style="cursor: pointer; color: #007bff;">Edit</span></li>
                            <li><span class="mx-3" id="delete-model" data-id="' . $models->id . '" data-name="' . e($models->name) . '" style="cursor: pointer; color: #007bff;">Delete</span></li>
                        </ul>
                    </div>
                    '
                    ;
            })
            ->make();
    }

    public function storeModel(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|unique:models,name|string|max:255'
        ]);
        $model = \App\Models\ModelsModel::Create($data);
        return response()->json(['message' => 'Model berhasil ditambahkan.']);
    }

    public function editModel($id): JsonResponse
    {
        $model = \App\Models\ModelsModel::findOrFail($id);
        return response()->json($model);
    }

    public function updateModel(Request $request, $id): JsonResponse
    {
        $model = \App\Models\ModelsModel::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|unique:models,name,' . $model->id . '|string|max:255',
        ]);
        $model->update($data);
        return response()->json(['message' => 'Model berhasil diperbarui.']);
    }

    public function deleteModel($id): JsonResponse
    {
        $model = \App\Models\ModelsModel::findOrFail($id);
        $model->delete();

        return response()->json(['message' => 'Model ' . $model->name . ' berhasil dihapus.']);
    }

    public function supplier(): View
    {
        return view('admin.set-atribut.setsupplier');
    }

    public function getSupplier(): JsonResponse
    {
        $suppliers = \App\Models\SuppliersModel::get();
        return DataTables::of($suppliers)
        ->addIndexColumn()
        ->addColumn('hitungSupplier', function ($suppliers) {
            $hitungSupplier = \App\Models\SuppliersModel::count();
            return $hitungSupplier;
        })
        ->addColumn('action', function ($suppliers) {
            return
            '
                    <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" title="More..."></button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><span class="mx-3" id="edit-supplier" data-id="' . $suppliers->id . '" data-name="' . e($suppliers->name) . '" style="cursor: pointer; color: #007bff;">Edit</span></li>
                            <li><span class="mx-3" id="delete-supplier" data-id="' . $suppliers->id . '" data-name="' . e($suppliers->name) . '" style="cursor: pointer; color: #007bff;">Delete</span></li>
                        </ul>
                    </div>
            '
            ;
        })
        ->make();
    }

    public function storeSupplier(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|unique:suppliers,name|string|max:255',
            'address' => 'required|string|max:255',
            'contactname' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
        ]);
        $supplier = \App\Models\SuppliersModel::Create($data);
        return response()->json(['message' => 'Supplier berhasil ditambahkan.']);
    }

    public function editSupplier($id): JsonResponse
    {
        $supplier = \App\Models\SuppliersModel::findOrFail($id);
        return response()->json($supplier);
    }

    public function updateSupplier(Request $request, $id): JsonResponse
    {
        $supplier = \App\Models\SuppliersModel::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|unique:suppliers,name,' . $supplier->id . '|string|max:255',
            'address' => 'required|string|max:255',
            'contactname' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
        ]);
        $supplier->update($data);
        return response()->json(['message' => 'Supplier berhasil diperbarui.']);
    }

    public function deleteSupplier($id): JsonResponse
    {
        $supplier = \App\Models\SuppliersModel::findOrFail($id);
        $supplier->delete();

        return response()->json(['message' => 'Supplier ' . $supplier->name . ' berhasil dihapus.']);
    }

    public function label(): View
    {
        $labels = \App\Models\LabelsModel::get();
        return view('admin.set-atribut.label', compact('labels'));
    }

    public function getLabel(Request $request): JsonResponse
    {
        $labels = \App\Models\LabelsModel::get();
        return DataTables::of($labels)
            ->addIndexColumn()
            ->addColumn('action', function ($labels) {
                return
                    '
                    <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" title="More..."></button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><span class="mx-3" id="edit-label" data-id="' . $labels->id . '" data-name="' . e($labels->name) . '" style="cursor: pointer; color: #007bff;">Edit</span></li>
                            <li><span class="mx-3" id="delete-label" data-id="' . $labels->id . '" data-name="' . e($labels->name) . '" style="cursor: pointer; color: #007bff;">Delete</span></li>
                        </ul>
                    </div>
                    '
                    ;
            })
            ->make();
    }

    public function storeLabel(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|unique:labels,name|string|max:255'
        ]);
        $label = \App\Models\LabelsModel::Create($data);

        return response()->json(['message' => 'Label berhasil ditambahkan.']);
    }

    public function editLabel($id): JsonResponse
    {
        $label = \App\Models\LabelsModel::findOrFail($id);
        return response()->json($label);
    }

    public function updateLabel(Request $request, $id): JsonResponse
    {
        $label = \App\Models\LabelsModel::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|unique:labels,name,' . $label->id . '|string|max:255',
            'color' => 'required|string|max:7'
        ]);
        $label->update($data);

        return response()->json(['message' => 'Label berhasil diperbarui.']);
    }

    public function deleteLabel($id): JsonResponse
    {
        $label = \App\Models\LabelsModel::findOrFail($id);
        $label->delete();

        return response()->json(['message' => 'Label ' . $label->name . ' berhasil dihapus.']);
    }

    public function kategorilisensi()
    {
        return view('admin.setkategorilisensi', ['title' => 'Setting Kategori Lisensi']);
    }

    public function lokasi()
    {
        return view('admin.set-atribut.setlokasi');
    }

    public function getLokasi(Request $request): JsonResponse
    {
        $lokasis = \App\Models\BuildingsModel::get();
        return DataTables::of($lokasis)
            ->addIndexColumn()
            ->addColumn('ruangan', function ($lokasis) {
                return $lokasis->locations->pluck('name')->implode(', ');
            })
            ->addColumn('action', function ($lokasis) {
                return
                    '
                    <div class="btn-group">
                        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" title="More..."></button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><span class="mx-3" id="edit-lokasi" data-id="' . $lokasis->id . '" data-name="' . e($lokasis->name) . '" style="cursor: pointer; color: #007bff;">Edit</span></li>
                            <li><span class="mx-3" id="delete-lokasi" data-id="' . $lokasis->id . '" data-name="' . e($lokasis->name) . '" style="cursor: pointer; color: #007bff;">Delete</span></li>
                        </ul>
                    </div>
                    '
                    ;
            })
            ->make();
    }

    public function storeLokasi(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|unique:locations,name|string|max:255'
        ]);
        $lokasi = \App\Models\LocationsModel::Create($data);

        return response()->json(['message' => 'Lokasi berhasil ditambahkan.']);
    }

    public function editLokasi($id): JsonResponse
    {
        $lokasi = \App\Models\LocationsModel::findOrFail($id);
        return response()->json($lokasi);
    }

    public function updateLokasi(Request $request, $id): JsonResponse
    {
        $lokasi = \App\Models\LocationsModel::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|unique:locations,name,' . $lokasi->id . '|string|max:255',
            'color' => 'required|string|max:7'
        ]);
        $lokasi->update($data);

        return response()->json(['message' => 'Lokasi berhasil diperbarui.']);
    }

    public function deleteLokasi($id): JsonResponse
    {
        $lokasi = \App\Models\LocationsModel::findOrFail($id);
        $lokasi->delete();

        return response()->json(['message' => 'Lokasi ' . $lokasi->name . ' berhasil dihapus.']);
    }
}
