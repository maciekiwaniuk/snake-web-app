<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * Wyświetlenie strony głównej
     */
    public function index()
    {
        return view('pages.welcome');
    }
}
