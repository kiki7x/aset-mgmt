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
        $totalGedung = \App\Models\BuildingsModel::count();
        $totalRuangan = \App\Models\LocationsModel::count();
        $totalTickets = \App\Models\TicketFront::count();
        $latestTickets = \App\Models\TicketFront::orderBy('created_at', 'desc')->take(5)->get();
        $totalAssetsPreventiveTarget = \App\Models\Maintenances_scheduleModel::count();
        $totalAssetsMaintained = \App\Models\Maintenances_scheduleModel::whereHas('maintenances', function ($query) {
                $query->where('status', 'Selesai');
            })
            ->count('asset_id');
        $totalAssetsPendingMaintenance = \App\Models\Maintenances_scheduleModel::whereDoesntHave('maintenances', function ($query) {
                $query->where('status', 'Selesai');
            })
            ->count();
        $korektifBaseQuery = \App\Models\MaintenancesModel::with('asset')
            ->whereDoesntHave('maintenance_schedule');

        $latestKorektifSegera = (clone $korektifBaseQuery)
            ->where('status', 'Segera Kerjakan')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $latestKorektifSedang = (clone $korektifBaseQuery)
            ->where('status', 'Sedang Dikerjakan')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $latestKorektifDitahan = (clone $korektifBaseQuery)
            ->where('status', 'Ditahan')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $latestKorektifSelesai = (clone $korektifBaseQuery)
            ->where('status', 'Selesai')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $latestPreventifUpcoming = \App\Models\Maintenances_scheduleModel::with('asset')
            ->whereBetween('start', [now(), now()->addDays(30)])
            ->orderBy('start', 'asc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalAssetTik',
            'totalAssetRt',
            'totalGedung',
            'totalRuangan',
            'totalTickets',
            'latestTickets',
            'totalAssetsMaintained',
            'totalAssetsPendingMaintenance',
            'latestKorektifSegera',
            'latestKorektifSedang',
            'latestKorektifDitahan',
            'latestKorektifSelesai',
            'latestPreventifUpcoming'
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