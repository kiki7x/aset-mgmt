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
        return view('admin.setatribut', compact('hitungklasifikasi', 'hitungkategori', 'hitungmerk', 'hitungmodel', 'hitungsupplier', 'hitunglabel', 'hitunglokasi')
        );
    }

    public function klasifikasi(): View
    {
        return view('admin.setklasifikasi');
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
        return view('admin.setkategori', compact('klasifikasis'));
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
        return view('admin.setmerk', ['title' => 'Setting Merk'],
        compact('merks')
        );
    }

    public function tipe()
    {
        return view('admin.settipe', ['title' => 'Setting Merk']);
    }

    public function supplier()
    {
        return view('admin.setsupplier', ['title' => 'Setting Supplier']);
    }

    public function label()
    {
        return view('admin.setlabel', ['title' => 'Setting Label']);
    }

    public function kategorilisensi()
    {
        return view('admin.setkategorilisensi', ['title' => 'Setting Kategori Lisensi']);
    }

    public function lokasi()
    {
        return view('admin.setlokasi', ['title' => 'Setting Lokasi']);
    }
}
