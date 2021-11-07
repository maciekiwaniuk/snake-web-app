<?php

namespace App\Http\Controllers;

use App\Models\UserGameData;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Showing user's profile page
     */
    public function show($username)
    {
        $user = User::query()
            ->select('id', 'name', 'avatar', 'user_banned')
            ->where('name', '=', $username)
            ->first();

        $user_game_data = UserGameData::query()
            ->select('points', 'coins', 'play_time_seconds',
                     'easy_record', 'medium_record', 'hard_record')
            ->where('user_id', '=', $user->id)
            ->first();


        return view('pages.profile', [
            'user' => $user,
            'user_game_data' => $user_game_data,
        ]);
    }
}
