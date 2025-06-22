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
        $totalGedung = \App\Models\LocationsModel::count();
        return view('admin.dashboard', compact('totalAssetTik', 'totalAssetRt', 'totalGedung'));
        
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