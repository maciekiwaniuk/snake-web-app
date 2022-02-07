<?php

namespace App\Http\Controllers;

use App\Models\GameHosting;
use App\Services\GameHostingsService;

class GameHostingsController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(GameHostingsService $service)
    {
        $this->gameHostingsService = $service;
    }

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

    /**
     * Increase amount of downloads by one
     */
    public function increaseDownloads()
    {
        $this->gameHostingsService->handleIncreaseDownloads();
    }
}
