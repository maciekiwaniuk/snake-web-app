<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserGameData;


class ApiSnakeGameController extends Controller
{
    /**
     * trying to log into account from login panel in dekstop app
     */
    public function login(Request $request)
    {
        $user = User::query()
            ->where('email', '=', $request->email)
            ->first();


        if (isset($user) && Hash::check($request->password, $user->password)) {
            // logged user is banned
            if ($user->user_banned == 1) {
                $result["success"] = false;
                $result["error_message"] = "Konto zostało zbanowane.";
            } else {
                // logged
                $result["success"] = true;
                $result["api_token"] = $user->api_token;
            }
        } else {
            // wrong email or password
            $result["success"] = false;
            $result["error_message"] = "Podany przez Ciebie email lub hasło było nieprawidłowe.";
        }

        // // check if user has newest version of game
        if (!isset($request->version) || $request->version != env('GAME_VERSION')) {
            $result["success"] = false;
            $result["error_message"] = "Posiadasz nieaktualną wersję gry.";
        }

        return response()->json([
            "result" => $result
        ]);
    }

    /**
     * returning user game data if token is valid
     */
    public function loadData(Request $request)
    {
        if (!isset($request->version) || $request->version != env('GAME_VERSION')) {
            return response()->json([
                'reason_to_close_game' => true,
            ]);
        }

        $user = User::query()
            ->where('api_token', '=', $request->api_token)
            ->with('usersGameData')
            ->first();

        return response()->json([
            "result" => $user
        ]);
    }

    /**
     * saving user game data by user's api token
     */
    public function saveData(Request $request)
    {
        // checking if request contains secret game key
        if (!isset($request->secret_game_key) || $request->secret_game_key != env('SECRET_GAME_KEY')) {
            exit();
        }

        $user = User::query()
            ->where('api_token', '=', $request->api_token)
            ->first();

        if (!isset($user) || $user->user_banned == 1 || !isset($request->version) ||
            $request->version != env('GAME_VERSION')) {
            return response()->json([
                'reason_to_close_game' => true,
            ]);
        }

        $user_game_data = UserGameData::query()
            ->where('user_id', '=', $user->id)
            ->first();

        $user_game_data->coins = $request->coins;
        $user_game_data->points = $request->points;
        $user_game_data->play_time_seconds = $request->play_time_seconds;

        $user_game_data->games_amount = $request->games_amount;
        $user_game_data->ate_fruits_amount = $request->ate_fruits_amount;
        $user_game_data->hit_wall = $request->hit_wall;
        $user_game_data->hit_snake = $request->hit_snake;
        $user_game_data->clicks = $request->clicks;
        $user_game_data->selected_level = $request->selected_level;

        $user_game_data->coins_upgrade_lvl = $request->coins_upgrade_lvl;
        $user_game_data->points_upgrade_lvl = $request->points_upgrade_lvl;
        $user_game_data->fruits_upgrade_lvl = $request->fruits_upgrade_lvl;

        $user_game_data->selected_fruits_upgrade_lvl = $request->selected_fruits_upgrade_lvl;

        $user_game_data->selected_head_skin = $request->selected_head_skin;
        $user_game_data->selected_body_skin = $request->selected_body_skin;
        $user_game_data->selected_fruit_skin = $request->selected_fruit_skin;
        $user_game_data->selected_board_skin = $request->selected_board_skin;

        $user_game_data->unlocked_medium = $request->unlocked_medium;
        $user_game_data->unlocked_hard = $request->unlocked_hard;
        $user_game_data->unlocked_speed = $request->unlocked_speed;

        $user_game_data->easy_record = $request->easy_record;
        $user_game_data->medium_record = $request->medium_record;
        $user_game_data->hard_record = $request->hard_record;
        $user_game_data->speed_record = $request->speed_record;

        $user_game_data->head_skins = $request->head_skins;
        $user_game_data->body_skins = $request->body_skins;
        $user_game_data->fruit_skins = $request->fruit_skins;
        $user_game_data->board_skins = $request->board_skins;

        $user_game_data->fps = $request->fps;
        $user_game_data->music = $request->music;
        $user_game_data->effects = $request->effects;
        $user_game_data->volume = $request->volume;

        $user_game_data->selected_game_music = $request->selected_game_music;
        $user_game_data->selected_menu_music = $request->selected_menu_music;

        $user_game_data->save();
    }
}
