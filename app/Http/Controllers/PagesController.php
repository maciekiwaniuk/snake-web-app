<?php

namespace App\Http\Controllers;

class PagesController extends Controller
{
    /**
     * Showing welcome index page
     */
    public function index()
    {
        return view('pages.welcome');
    }

    /**
     * Showing offline fallback page
     */
    public function offlineFallback()
    {
        return view('pages.offline-fallback');
    }
}
