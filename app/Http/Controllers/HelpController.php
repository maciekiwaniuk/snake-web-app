<?php

namespace App\Http\Controllers;

class HelpController extends Controller
{
    public function index()
    {
        return view('pages.help');
    }

    public function show($selected)
    {
        return view('pages.help', [
            'selected' => $selected
        ]);
    }
}
