<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//import return type redirectResponse
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $totalAssetTik = \App\Models\AssetsModel::where('classification_id', 2)->count();
        $totalAssetRt = \App\Models\AssetsModel::whereIn('classification_id', [3, 4])->count();
        $totalGedung = \App\Models\BuildingsModel::count();
        $totalRuangan = \App\Models\LocationsModel::count();
        $totalTickets = \App\Models\TicketsModel::count();
        $latestTickets = \App\Models\TicketsModel::orderBy('created_at', 'desc')->take(5)->get();
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

        $latestKorektifItems = collect()
            ->concat($latestKorektifSegera)
            ->concat($latestKorektifSedang)
            ->concat($latestKorektifDitahan)
            ->concat($latestKorektifSelesai)
            ->sortByDesc('created_at')
            ->take(5)
            ->values();

        $latestPreventifUpcoming = \App\Models\Maintenances_scheduleModel::with('asset')
            ->whereBetween('start', [now(), now()->addDays(30)])
            ->orderBy('start', 'asc')
            ->take(5)
            ->get();

        // Counter tambahan
        $totalBorrowings = \App\Models\BorrowingsModel::count();
        $totalArticles = \App\Models\KbArticlesModel::where('is_published', true)->count();
        $totalUsers = \App\Models\User::count();

        // Chart Pemeliharaan bulanan
        $year = $request->get('year', date('Y'));
        $chartBelum = array_fill(0, 12, 0);
        $chartSudah = array_fill(0, 12, 0);
        $chartKorektif = array_fill(0, 12, 0);

        $belumRaw = \App\Models\Maintenances_scheduleModel::selectRaw('MONTH(start) as bulan, COUNT(*) as total')
            ->whereYear('start', $year)
            ->whereDoesntHave('maintenances', function ($q) {
                $q->where('status', 'Selesai');
            })
            ->groupByRaw('MONTH(start)')
            ->pluck('total', 'bulan')
            ->toArray();

        foreach ($belumRaw as $bulan => $total) {
            $chartBelum[$bulan - 1] = (int) $total;
        }

        $sudahRaw = \App\Models\MaintenancesModel::selectRaw('MONTH(start) as bulan, COUNT(*) as total')
            ->whereYear('start', $year)
            ->whereNotNull('maintenance_schedule_id')
            ->where('status', 'Selesai')
            ->groupByRaw('MONTH(start)')
            ->pluck('total', 'bulan')
            ->toArray();

        foreach ($sudahRaw as $bulan => $total) {
            $chartSudah[$bulan - 1] = (int) $total;
        }

        $korektifRaw = \App\Models\MaintenancesModel::selectRaw('MONTH(start) as bulan, COUNT(*) as total')
            ->whereYear('start', $year)
            ->whereNull('maintenance_schedule_id')
            ->groupByRaw('MONTH(start)')
            ->pluck('total', 'bulan')
            ->toArray();

        foreach ($korektifRaw as $bulan => $total) {
            $chartKorektif[$bulan - 1] = (int) $total;
        }

        $currentYear = (int) date('Y');
        $years = range($currentYear - 5, $currentYear + 1);

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
            'latestKorektifItems',
            'latestPreventifUpcoming',
            'totalBorrowings',
            'totalArticles',
            'totalUsers',
            'chartBelum',
            'chartSudah',
            'chartKorektif',
            'year',
            'years'
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