<?php

namespace App\Http\Controllers;

class PagesController extends Controller
{
    /**
     * Show welcome index page
     */
    public function index()
    {
        return view('pages.welcome');
    }

    /**
     * Show offline fallback page
     */
    public function showOfflineFallback()
    {
        return view('pages.offline-fallback');
    }

    /**
     * Show mini-game page
     */
    public function showMiniGamePage()
    {
        return view('pages.mini-game');
    }

    /**
     * Show gallery page
     */
    public function showGalleryPage()
    {
        return view('pages.gallery');
    }
}
