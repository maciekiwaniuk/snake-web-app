<?php

namespace App\Http\Controllers;

class SupportController extends Controller
{
    /**
     * Showing support index page
     */
    public function index()
    {
        return view('pages.support');
    }

    /**
     * Showing support index page with
     * selected one tab
     */
    public function show($selected)
    {
        return view('pages.support', [
            'selected' => $selected
        ]);
    }
}
