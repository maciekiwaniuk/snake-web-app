<?php

namespace App\Http\Controllers;

class HelpController extends Controller
{
    /**
     * Show help index page
     */
    public function index()
    {
        return view('pages.help');
    }

    /**
     * Show help index page with
     * selected one tab
     */
    public function show($selected)
    {
        return view('pages.help', [
            'selected' => $selected
        ]);
    }
}
