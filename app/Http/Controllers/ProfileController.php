<?php

namespace App\Http\Controllers;

use App\Models\UserGameData;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Showing user's profile page
     */
    public function show($username)
    {
        $user = $this->findUserByUsername($username);

        if ($user->user_game_data_id != null) {
            $user_game_data = UserGameData::query()
                ->where('id', '=', $user->user_game_data_id)
                ->first();
        } else {
            $user_game_data = '-';
        }

        logger($user_game_data);

        return view('pages.profile', [
            'user' => $user,
            'user_game_data' => $user_game_data,
        ]);
    }
}
