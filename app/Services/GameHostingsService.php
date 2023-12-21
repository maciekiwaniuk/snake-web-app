<?php

namespace App\Services;

use App\Http\Requests\Admin\StoreGameHostingRequest;
use Illuminate\Http\Request;
use App\Models\GameHosting;
use Illuminate\Support\Facades\Redis;

class GameHostingsService
{
    public function store(StoreGameHostingRequest $request)
    {
        GameHosting::create([
            'name' => $request->name,
            'link' => $request->link
        ]);
    }

    public function destroy(int $hosting_id)
    {
        $game_hosting = GameHosting::query()
            ->where('id', '=', $hosting_id)
            ->first();
        $game_hosting->delete();
    }

    public function update(Request $request, int $hosting_id)
    {
        $game_hosting = GameHosting::query()
            ->where('id', '=', $hosting_id)
            ->first();

        $game_hosting->update([
            'name' => $request->name,
            'link' => $request->link
        ]);
    }

    public function handleIncreaseDownloads()
    {
        if (config('features.redis.enabled')) {
            $key = 'total_game_downloads_amount_' . config('app.env');

            if (Redis::get($key) === null) {
                Redis::set($key, 0);
            }

            Redis::set($key, Redis::get($key) + 1);
        }
    }

}
