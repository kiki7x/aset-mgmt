<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class KalenderPemeliharaan extends Controller
{
    public function index(): View
    {
        return view('admin.kalender-pemeliharaan.index');
    }
}
