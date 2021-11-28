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
     * Trying to log into account from login panel in dekstop app
     */
    public function login(Request $request)
    {
        $user = User::query()
            ->where('email', '=', $request->email)
            ->first();


        if (isset($user) && Hash::check($request->password, $user->password)) {
            // logged user is banned
            if ($user->isBanned()) {
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
     * Returning user game data if token is valid
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
            ->with('userGameData')
            ->first();

        $ip = $request->getClientIp();

        return response()->json([
            "result" => $user,
            "ip" => $ip
        ]);
    }

    /**
     * Saving user game data by user's api token
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
        $user_game_data->total_coins_earned = $request->total_coins_earned;
        $user_game_data->points = $request->points;
        $user_game_data->play_time_seconds = $request->play_time_seconds;

        $user_game_data->games_amount = $request->games_amount;
        $user_game_data->hit_wall = $request->hit_wall;
        $user_game_data->hit_snake = $request->hit_snake;
        $user_game_data->clicks = $request->clicks;
        $user_game_data->selected_level = $request->selected_level;

        $user_game_data->ate_fruits_amount = $request->ate_fruits_amount;
        $user_game_data->ate_fruits_on_easy = $request->ate_fruits_on_easy;
        $user_game_data->ate_fruits_on_medium = $request->ate_fruits_on_medium;
        $user_game_data->ate_fruits_on_hard = $request->ate_fruits_on_hard;
        $user_game_data->ate_fruits_on_speed = $request->ate_fruits_on_speed;

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

        $user_game_data->selected_menu_music = $request->selected_menu_music;

        $user_game_data->save();
    }

    /**
     * Saving log when user opened game
     */
    public function createOpenGameLog(Request $request)
    {
        if (!isset($request->secret_game_key) || $request->secret_game_key != env('SECRET_GAME_KEY')) {
            exit();
        }

        $user = User::query()
            ->where('api_token', '=', $request->api_token)
            ->first();

        if (isset($user)) {
            $this->createGameAppLog(
                'game_open',
                'Użytkownik '.$user->name.' wszedł do gry.',
                $request->user_id,
                $request->ip
            );
        }
    }

    /**
     * Saving log when user quit game
     */
    public function createExitGameLog(Request $request)
    {
        if (!isset($request->secret_game_key) || $request->secret_game_key != env('SECRET_GAME_KEY')) {
            exit();
        }

        $user = User::query()
            ->where('api_token', '=', $request->api_token)
            ->first();

        if (isset($user)) {
            $this->createGameAppLog(
                'game_leave',
                'Użytkownik '.$user->name.' wyszedł z gry.',
                $request->user_id,
                $request->ip
            );
        }
    }

    /**
     * Saving log when user logout from game
     */
    public function createLogoutGameLog(Request $request)
    {
        if (!isset($request->secret_game_key) || $request->secret_game_key != env('SECRET_GAME_KEY')) {
            exit();
        }

        $user = User::query()
            ->where('api_token', '=', $request->api_token)
            ->first();

        if (isset($user)) {
            $this->createGameAppLog(
                'game_logout',
                'Użytkownik '.$user->name.' wylogował się z gry.',
                $request->user_id,
                $request->ip
            );
        }
    }
}
