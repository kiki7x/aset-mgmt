<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{

    public function testing()
    {
        return view('frontsite.testing');
    }

    public function index()
    {
        $assets = \App\Models\AssetsModel::get();
        return view('frontsite.index', compact('assets'));
    }

    public function profil()
    {
        return view('frontsite.profil');
    }

    public function layanan()
    {
        $assets = \App\Models\AssetsModel::get();
        return view('frontsite.layanan', compact('assets'));
    }

    public function statistik()
    {
        $assets = \App\Models\AssetsModel::get();
        return view('frontsite.statistik', compact('assets'));
    }

    public function team()
    {
        return view('frontsite.team');
    }

    public function faq()
    {
        return view('frontsite.faq');
    }

    public function lacak()
    {
        return view('frontsite.lacak');
    }

    public function lacak_show($id)
    {
        $lacak = \App\Models\AssetsModel::where('tag', $id)->firstOrFail();
        return view('frontsite.lacak_show', compact('lacak'));
    }
}
