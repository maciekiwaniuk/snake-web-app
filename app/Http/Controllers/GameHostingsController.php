<?php

namespace App\Http\Controllers;

use App\Models\Hosting;

class GameHostingsController extends Controller
{
    /**
     * Showing hostings index page
     */
    public function index()
    {
        $hostings = Hosting::all();

        return view('pages.download', [
            'hostings' => $hostings
        ]);
    }
}
