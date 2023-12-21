<?php

namespace App\Http\Controllers;

class PagesController extends Controller
{
    public function index()
    {
        return view('pages.welcome');
    }

    public function showOfflineFallback()
    {
        return view('pages.offline-fallback');
    }

    public function showMiniGamePage()
    {
        return view('pages.mini-game');
    }

}
