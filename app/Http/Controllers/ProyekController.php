<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProyekController extends Controller
{
    public function index()
    {
        return view('admin.proyek.index');
    }
}
