<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenancesModel;
use App\Models\AssetsModel;

use Illuminate\Support\Facades\Log;

class ShowAsetRtController extends Controller
{
    public function getOverviewContent($id)
    {
        // Mengambil data aset beserta relasi user.
        // Jika aset tidak ditemukan, akan otomatis melempar 404.
        $asset = \App\Models\AssetsModel::findOrFail($id);

        return view('admin.components.overview-aset', compact(
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
    //     return view('admin.components.pemeliharaan', compact('id', 'maintenances', 'asset'));
    // }

    public function getPenugasanContent($id)
    {
        $asset = \App\Models\AssetsModel::findOrFail($id); // Menggunakan model Maintenance::with('item')->latest()->get();
        Log::info("Loading Penugasan for asset ID: $id");
        return view('admin.components.penugasan', compact('id', 'asset'));
    }

    public function getTicketsContent($id)
    {
        $asset = \App\Models\AssetsModel::findOrFail($id);
        Log::info("Loading Tickets for asset ID: $id");
        return view('admin.components.tickets', compact('id', 'asset'));
    }

    public function getFilesContent($id)
    {
        // Logika untuk mengambil data Files berdasarkan $id
        // Contoh data dummy:
        $files = [
            ['name' => 'Manual Book.pdf', 'size' => '2.5 MB', 'uploaded_at' => '2024-01-15'],
            ['name' => 'Invoice Pembelian.jpg', 'size' => '0.8 MB', 'uploaded_at' => '2023-12-01'],
        ];
        $asset = \App\Models\AssetsModel::findOrFail($id);
        Log::info("Loading Files for asset ID: $id");
        return view('admin.components.files', compact('id', 'files', 'asset'));
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
        return view('admin.components.timelog', compact('id', 'asset', 'timeLogs'));
    }

    public function getEditAssetContent($id)
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
        $users = \App\Models\User::all();
        $manufacturers = \App\Models\ManufacturersModel::all();
        $models = \App\Models\ModelsModel::all();
        $suppliers = \App\Models\SuppliersModel::all();
        $locations = \App\Models\LocationsModel::all();
        $statuses = \App\Models\LabelsModel::all();

        Log::info("Loading Edit Asset for asset ID: $id");
        return view('admin.components.editaset', compact(
            'id',
            'asset',
            'classifications',
            'categories',
            'users',
            'manufacturers',
            'models',
            'suppliers',
            'locations',
            'statuses'
        ));
    }

}
