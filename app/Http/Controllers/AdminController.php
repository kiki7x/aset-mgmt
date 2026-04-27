<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//import return type redirectResponse
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $totalAssetTik = \App\Models\AssetsModel::where('classification_id', 2)->count();
        $totalAssetRt = \App\Models\AssetsModel::whereIn('classification_id', [3, 4])->count();
        $totalGedung = \App\Models\LocationsModel::count();
        $totalAssets = \App\Models\AssetsModel::count();
        $assetsMaintained = \App\Models\MaintenancesModel::where('status', 'Selesai')->distinct('asset_id')->count('asset_id');
        $assetsNotMaintained = max(0, $totalAssets - $assetsMaintained);
        $maintenanceDonePercent = $totalAssets ? round($assetsMaintained / $totalAssets * 100) : 0;
        $maintenanceNotDonePercent = 100 - $maintenanceDonePercent;

        return view('admin.dashboard', compact(
            'totalAssetTik',
            'totalAssetRt',
            'totalGedung',
            'totalAssets',
            'assetsMaintained',
            'assetsNotMaintained',
            'maintenanceDonePercent',
            'maintenanceNotDonePercent'
        ));
    }

    public function asettik()
    {
        return view('admin.asettik', 
        [
            'title' => 'Kelola Aset TIK',
        ]);
        
    }

    public function asetrt()
    {
        return view('admin.asetrt', 
        [
            'title' => 'Kelola Aset Rumah Tangga',
        ]
        );
        
    }
}