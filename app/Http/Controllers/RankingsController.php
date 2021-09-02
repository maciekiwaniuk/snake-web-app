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
     * coins ranking
     */
    public function getCoins()
    {
        // $data = User::query()
        //     ->with('usersGameData')
        //     ->where('user_game_data_id', '!=', 'null')
        //     ->whereHas('usersGameData', function($query) {
        //         $query->where('coins', '>', 0);
        //         $query->orderBy('coins', 'asc');
        //     })
        //     ->get();
        $data = DB::select('SELECT * FROM users, users_game_data
                            WHERE users.user_game_data_id = users_game_data.id
                            AND users.user_banned = 0
                            AND users_game_data.coins > 0
                            ORDER BY users_game_data.coins DESC, users_game_data.created_at ASC');

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
        $data = DB::select('SELECT * FROM users, users_game_data
                            WHERE users.user_game_data_id = users_game_data.id
                            AND users.user_banned = 0
                            AND users_game_data.records_easy > 0
                            ORDER BY users_game_data.records_easy DESC, users_game_data.created_at ASC');

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
        $data = DB::select('SELECT * FROM users, users_game_data
                            WHERE users.user_game_data_id = users_game_data.id
                            AND users.user_banned = 0
                            AND users_game_data.records_medium > 0
                            ORDER BY users_game_data.records_medium DESC, users_game_data.created_at ASC');

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
        $data = DB::select('SELECT * FROM users, users_game_data
                            WHERE users.user_game_data_id = users_game_data.id
                            AND users.user_banned = 0
                            AND users_game_data.records_hard > 0
                            ORDER BY users_game_data.records_hard DESC, users_game_data.created_at ASC');

        return response()->json([
            'data' => $data,
        ]);
    }
}
