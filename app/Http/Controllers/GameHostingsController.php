<?php

namespace App\Http\Controllers;

use App\Models\GameHosting;
use Illuminate\Support\Facades\Redis;

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

    /**
     * Increase amount of downloads by one
     */
    public function increaseDownloads()
    {
        if (env('REDIS_CONFIGURED')) {

            $key = 'total_game_downloads_amount_'.env('APP_ENV');

            if (Redis::get($key) === null) {
                Redis::set($key, 0);
            }

            Redis::set($key, Redis::get($key) + 1);
        }
    }
}
