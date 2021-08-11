<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hosting;

class GameHostingsController extends Controller
{
    /**
     * Wyświetlenie strony z linkami
     * do hostingów do pobrania gry
     */
    public function index()
    {
        $hostings = Hosting::all();

        return view('pages.download', [
            'hostings' => $hostings
        ]);
    }
}
