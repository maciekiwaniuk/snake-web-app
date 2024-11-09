<?php

namespace App\Http\Controllers;

use App\Models\User;

class RankingsController extends Controller
{
    public function index()
    {
        return view('pages.ranking');
    }

    public function getPoints()
    {
        $data = User::query()
            ->join('users_game_data', 'user_id', '=', 'users.id')
            ->select('id', 'name', 'avatar_path', 'users_game_data.points')
            ->where('user_banned', '=', 0)
            ->where('users_game_data.points', '>', 0)
            ->orderBy('users_game_data.points', 'DESC')
            ->orderBy('users_game_data.updated_at', 'DESC')
            ->get();

        return response()->json([
            'data' => $data,
        ]);
    }

    public function getCoins()
    {
        $data = User::query()
            ->join('users_game_data', 'user_id', '=', 'users.id')
            ->select('id', 'name', 'avatar_path', 'users_game_data.coins')
            ->where('user_banned', '=', 0)
            ->where('users_game_data.coins', '>', 0)
            ->orderBy('users_game_data.coins', 'DESC')
            ->orderBy('users_game_data.updated_at', 'DESC')
            ->get();

        return response()->json([
            'data' => $data,
        ]);
    }

    public function getEasy()
    {
        $data = User::query()
            ->join('users_game_data', 'user_id', '=', 'users.id')
            ->select('id', 'name', 'avatar_path', 'users_game_data.easy_record')
            ->where('user_banned', '=', 0)
            ->where('users_game_data.easy_record', '>', 0)
            ->orderBy('users_game_data.easy_record', 'DESC')
            ->orderBy('users_game_data.updated_at', 'DESC')
            ->get();

        return response()->json([
            'data' => $data,
        ]);
    }

    public function getMedium()
    {
        $data = User::query()
            ->join('users_game_data', 'user_id', '=', 'users.id')
            ->select('id', 'name', 'avatar_path', 'users_game_data.medium_record')
            ->where('user_banned', '=', 0)
            ->where('users_game_data.medium_record', '>', 0)
            ->orderBy('users_game_data.medium_record', 'DESC')
            ->orderBy('users_game_data.updated_at', 'DESC')
            ->get();

        return response()->json([
            'data' => $data,
        ]);
    }

    public function getHard()
    {
        $data = User::query()
            ->join('users_game_data', 'user_id', '=', 'users.id')
            ->select('id', 'name', 'avatar_path', 'users_game_data.hard_record')
            ->where('user_banned', '=', 0)
            ->where('users_game_data.hard_record', '>', 0)
            ->orderBy('users_game_data.hard_record', 'DESC')
            ->orderBy('users_game_data.updated_at', 'DESC')
            ->get();

        return response()->json([
            'data' => $data,
        ]);
    }

    public function getSpeed()
    {
        $data = User::query()
            ->join('users_game_data', 'user_id', '=', 'users.id')
            ->select('id', 'name', 'avatar_path', 'users_game_data.speed_record')
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
