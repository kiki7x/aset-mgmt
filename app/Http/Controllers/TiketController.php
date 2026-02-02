<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TiketController extends Controller
{
    public function index()
    {
        return view('admin.tiket.index');
    }
}
