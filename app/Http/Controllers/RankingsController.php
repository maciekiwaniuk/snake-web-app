<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class RankingsController extends Controller
{
    /**
     * Showing ranking index page
     */
    public function index()
    {
        return view('pages.ranking');
    }

    /**
     * Returning data with user's
     * points ranking
     */
    public function getPoints()
    {
        $data = DB::select('SELECT users.name, users.avatar, users.permision, users_game_data.points
                            FROM users, users_game_data
                            WHERE users.id = users_game_data.user_id
                            AND users.user_banned = 0
                            AND users_game_data.points > 0
                            ORDER BY users_game_data.points DESC, users_game_data.updated_at DESC');

        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Returning data with user's
     * coins ranking
     */
    public function getCoins()
    {
        $data = DB::select('SELECT users.name, users.avatar, users.permision, users_game_data.coins
                            FROM users, users_game_data
                            WHERE users.id = users_game_data.user_id
                            AND users.user_banned = 0
                            AND users_game_data.coins > 0
                            ORDER BY users_game_data.coins DESC, users_game_data.updated_at DESC');

        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Returning data with user's
     * records on easy ranking
     */
    public function getEasy()
    {
        $data = DB::select('SELECT users.name, users.avatar, users.permision, users_game_data.easy_record
                            FROM users, users_game_data
                            WHERE users.id = users_game_data.user_id
                            AND users.user_banned = 0
                            AND users_game_data.easy_record > 0
                            ORDER BY users_game_data.easy_record DESC, users_game_data.updated_at DESC');

        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Returning data with user's
     * records on medium ranking
     */
    public function getMedium()
    {
        $data = DB::select('SELECT users.name, users.avatar, users.permision, users_game_data.medium_record
                            FROM users, users_game_data
                            WHERE users.id = users_game_data.user_id
                            AND users.user_banned = 0
                            AND users_game_data.medium_record > 0
                            ORDER BY users_game_data.medium_record DESC, users_game_data.updated_at DESC');

        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Returning data with user's
     * records on hard ranking
     */
    public function getHard()
    {
        $data = DB::select('SELECT users.name, users.avatar, users.permision, users_game_data.hard_record
                            FROM users, users_game_data
                            WHERE users.id = users_game_data.user_id
                            AND users.user_banned = 0
                            AND users_game_data.hard_record > 0
                            ORDER BY users_game_data.hard_record DESC, users_game_data.updated_at DESC');

        return response()->json([
            'data' => $data,
        ]);
    }
}
