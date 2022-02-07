<?php

namespace App\Services;

use App\Http\Requests\Admin\StoreGameHostingRequest;
use Illuminate\Http\Request;
use App\Models\GameHosting;
use Illuminate\Support\Facades\Redis;

class GameHostingsService
{

    /**
     * Handle store game hosting
     */
    public function store(StoreGameHostingRequest $request)
    {
        GameHosting::create([
            'name' => $request->name,
            'link' => $request->link
        ]);
    }

    /**
     * Handle destroy game hosting
     */
    public function destroy($hosting_id)
    {
        $game_hosting = GameHosting::query()
            ->where('id', '=', $hosting_id)
            ->first();
        $game_hosting->delete();
    }

    /**
     * Handle update game hosting
     */
    public function update(Request $request, $hosting_id)
    {
        $game_hosting = GameHosting::query()
            ->where('id', '=', $hosting_id)
            ->first();

        $game_hosting->update([
            'name' => $request->name,
            'link' => $request->link
        ]);
    }

    /**
     * Handle increase amount of downloads for statistics
     */
    public function handleIncreaseDownloads()
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
