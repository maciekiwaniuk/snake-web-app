<?php

namespace App\Http\Controllers;

use App\Models\User;

class RankingsController extends Controller
{
    /**
     * Show ranking index page
     */
    public function index()
    {
        return view('pages.ranking');
    }

    /**
     * Return data with user's
     * points ranking
     */
    public function getPoints()
    {
        $data = User::query()
            ->join('users_game_data', 'user_id', '=', 'users.id')
            ->select('id', 'name', 'avatar', 'users_game_data.points')
            ->where('user_banned', '=', 0)
            ->where('users_game_data.points', '>', 0)
            ->orderBy('users_game_data.points', 'DESC')
            ->orderBy('users_game_data.updated_at', 'DESC')
            ->get();

        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Return data with user's
     * coins ranking
     */
    public function getCoins()
    {
        $data = User::query()
            ->join('users_game_data', 'user_id', '=', 'users.id')
            ->select('id', 'name', 'avatar', 'users_game_data.coins')
            ->where('user_banned', '=', 0)
            ->where('users_game_data.coins', '>', 0)
            ->orderBy('users_game_data.coins', 'DESC')
            ->orderBy('users_game_data.updated_at', 'DESC')
            ->get();

        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Return data with user's
     * records on easy ranking
     */
    public function getEasy()
    {
        $data = User::query()
            ->join('users_game_data', 'user_id', '=', 'users.id')
            ->select('id', 'name', 'avatar', 'users_game_data.easy_record')
            ->where('user_banned', '=', 0)
            ->where('users_game_data.easy_record', '>', 0)
            ->orderBy('users_game_data.easy_record', 'DESC')
            ->orderBy('users_game_data.updated_at', 'DESC')
            ->get();

        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Return data with user's
     * records on medium ranking
     */
    public function getMedium()
    {
        $data = User::query()
            ->join('users_game_data', 'user_id', '=', 'users.id')
            ->select('id', 'name', 'avatar', 'users_game_data.medium_record')
            ->where('user_banned', '=', 0)
            ->where('users_game_data.medium_record', '>', 0)
            ->orderBy('users_game_data.medium_record', 'DESC')
            ->orderBy('users_game_data.updated_at', 'DESC')
            ->get();

        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Return data with user's
     * records on hard ranking
     */
    public function getHard()
    {
        $data = User::query()
            ->join('users_game_data', 'user_id', '=', 'users.id')
            ->select('id', 'name', 'avatar', 'users_game_data.hard_record')
            ->where('user_banned', '=', 0)
            ->where('users_game_data.hard_record', '>', 0)
            ->orderBy('users_game_data.hard_record', 'DESC')
            ->orderBy('users_game_data.updated_at', 'DESC')
            ->get();

        return response()->json([
            'data' => $data,
        ]);
    }

    /**
     * Return data with user's
     * records on hard ranking
     */
    public function getSpeed()
    {
        $data = User::query()
            ->join('users_game_data', 'user_id', '=', 'users.id')
            ->select('id', 'name', 'avatar', 'users_game_data.speed_record')
            ->where('user_banned', '=', 0)
            ->where('users_game_data.speed_record', '>', 0)
            ->orderBy('users_game_data.speed_record', 'DESC')
            ->orderBy('users_game_data.updated_at', 'DESC')
            ->get();

        return response()->json([
            'data' => $data,
        ]);
    }
}
