<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//import return type redirectResponse
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $totalAssetTik = \App\Models\AssetsModel::where('classification_id', 2)->count();
        $totalAssetRt = \App\Models\AssetsModel::whereIn('classification_id', [3, 4])->count();
        $totalGedung = \App\Models\BuildingsModel::count();
        $totalRuangan = \App\Models\LocationsModel::count();
        $totalTickets = \App\Models\TicketFront::count();
        $latestTickets = \App\Models\TicketFront::orderBy('created_at', 'desc')->take(5)->get();
        $totalAssetsMaintained = \App\Models\MaintenancesModel::where('status', 'Selesai')->distinct('asset_id')->count('asset_id');
        $totalAssetsPendingMaintenance = \App\Models\AssetsModel::count() - $totalAssetsMaintained;
        return view('admin.dashboard', compact('totalAssetTik', 'totalAssetRt', 'totalGedung', 'totalRuangan', 'totalTickets', 'latestTickets', 'totalAssetsMaintained', 'totalAssetsPendingMaintenance'));
        
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