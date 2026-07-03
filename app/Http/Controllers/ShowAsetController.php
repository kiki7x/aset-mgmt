<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\MaintenancesModel;
use App\Models\FilesModel;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ShowAsetController extends Controller
{
    public function getOverviewContent($id)
    {
        // Mengambil data aset beserta relasi user.
        // Jika aset tidak ditemukan, akan otomatis melempar 404.
        $asset = \App\Models\AssetsModel::findOrFail($id);

        return view('admin.detailaset.overview-aset', compact(
            'id',
            'asset',
        ));
    }
    // public function getPenjadwalanContent($id)
    // {
    //     $maintenances = \App\Models\MaintenancesModel::where('asset_id', $id)->get(); // Menggunakan model Maintenance::with('item')->latest()->get();
    //     // $asset = \App\Models\AssetsModel::get(); // Untuk dropdown di form tambah
    //     $asset = \App\Models\AssetsModel::findOrFail($id); // Menggunakan model Maintenance::with('item')->latest()->get();
    //     Log::info("Loading Penjadwalan for asset ID: $id");
    //     return view('admin.detailaset.pemeliharaan', compact('id', 'maintenances', 'asset'));
    // }

    // public function getPenugasanContent($id)
    // {
    //     $asset = \App\Models\AssetsModel::findOrFail($id); // Menggunakan model Maintenance::with('item')->latest()->get();
    //     Log::info("Loading Penugasan for asset ID: $id");
    //     return view('admin.detailaset.penugasan', compact('id', 'asset'));
    // }

    public function getTicketsContent($id)
    {
        $asset = \App\Models\AssetsModel::findOrFail($id);
        Log::info("Loading Tickets for asset ID: $id");
        return view('admin.detailaset.tickets', compact('id', 'asset'));
    }

    public function getFilesContent($id)
    {
        $asset = \App\Models\AssetsModel::with('files')->findOrFail($id);
        Log::info("Loading Files for asset ID: $id");
        return view('admin.detailaset.files', compact('id', 'asset'));
    }

    public function uploadFile(Request $request, $id): JsonResponse
    {
        $request->validate([
            'file' => 'required|file|max:10240|mimes:pdf,jpg,jpeg,png',
            'name' => 'nullable|string|max:255',
        ]);

        $asset = \App\Models\AssetsModel::findOrFail($id);
        $file = $request->file('file');
        $originalName = $file->getClientOriginalName();
        $fileName = time() . '_' . $originalName;
        $filePath = $file->store('asset_files', 'public');

        $displayName = $request->filled('name') ? $request->input('name') : $originalName;

        FilesModel::create([
            'asset_id' => $asset->id,
            'name' => $displayName,
            'file' => $filePath,
        ]);

        return response()->json(['message' => 'File berhasil diupload.']);
    }

    public function deleteFile($id, $fileId): JsonResponse
    {
        $file = FilesModel::where('asset_id', $id)->findOrFail($fileId);

        if (Storage::disk('public')->exists($file->file)) {
            Storage::disk('public')->delete($file->file);
        }

        $file->delete();

        return response()->json(['message' => 'File berhasil dihapus.']);
    }

    public function getTimeLogContent($id)
    {
        // Logika untuk mengambil data Time Log berdasarkan $id
        // Contoh data dummy:
        $timeLogs = [
            ['date' => '2025-05-10', 'activity' => 'Pengecekan Harian', 'duration' => '1 jam'],
            ['date' => '2025-05-15', 'activity' => 'Penggantian Ban', 'duration' => '2.5 jam'],
        ];
        $asset = \App\Models\AssetsModel::findOrFail($id);
        Log::info("Loading Time Log for asset ID: $id");
        return view('admin.detailaset.timelog', compact('id', 'asset', 'timeLogs'));
    }

    public function getEditAssetContent($id): View
    {
        // Mengambil data aset beserta relasi user.
        // Jika aset tidak ditemukan, akan otomatis melempar 404.
        $asset = \App\Models\AssetsModel::findOrFail($id);

        // Ambil data untuk dropdowns
        $classifications = \App\Models\AssetclassificationsModel::all();

        // cek klasifikasi aset dulu untuk dropdown kategori
        if ($asset->classification_id == 2) {
            $categories = \App\Models\AssetcategoriesModel::whereIn('classification_id', [2])->get();
        } else {
            $categories = \App\Models\AssetcategoriesModel::whereIn('classification_id', [3, 4])->get();
        }
        // fetch all data
        $users = \App\Models\User::all();
        $manufacturers = \App\Models\ManufacturersModel::all();
        $models = \App\Models\ModelsModel::all();
        $suppliers = \App\Models\SuppliersModel::all();
        $locations = \App\Models\LocationsModel::with('building')->get();
        $statuses = \App\Models\LabelsModel::all();

        Log::info("Loading Edit Asset for asset ID: $id");
        return view('admin.detailaset.editaset', compact(
            'id',
            'asset',
            'classifications',
            'categories',
            'users',
            'manufacturers',
            'models',
            'suppliers',
            'locations',
            'statuses',
        ));
    }

}
