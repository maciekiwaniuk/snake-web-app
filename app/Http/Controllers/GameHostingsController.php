<?php

namespace App\Http\Controllers;

use App\Models\GameHosting;

class GameHostingsController extends Controller
{
    /**
     * Show hostings index page
     */
    public function index()
    {
        $game_hostings = GameHosting::all();

        return view('pages.download', [
            'game_hostings' => $game_hostings
        ]);
    }
}
