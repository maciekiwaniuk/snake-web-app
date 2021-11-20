<?php

namespace App\Http\Controllers;

class HelpController extends Controller
{
    /**
     * Showing help index page
     */
    public function index()
    {
        return view('pages.help');
    }

    /**
     * Showing help index page with
     * selected one tab
     */
    public function show($selected)
    {
        return view('pages.help', [
            'selected' => $selected
        ]);
    }
}
