<?php

namespace App\Http\Controllers;

use App\Models\GameHosting;
use App\Services\GameHostingsService;

class GameHostingsController extends Controller
{
    public function __construct(GameHostingsService $service)
    {
        $this->gameHostingsService = $service;
    }

    public function index()
    {
        $game_hostings = GameHosting::all();

        return view('pages.download', [
            'game_hostings' => $game_hostings
        ]);
    }

    public function increaseDownloads()
    {
        $this->gameHostingsService->handleIncreaseDownloads();
    }
}
