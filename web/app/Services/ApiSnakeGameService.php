<?php

namespace App\Services;

use App\Models\GameRequest;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ApplicationLog;
use App\Models\UserGameData;
use App\Models\User;

class ApiSnakeGameService
{
    private function validateHash(Request $request): bool
    {
        $secretHash = GameRequest::query()
            ->where('secret_hash', $request->input('secret_hash'))
            ->first();
        if ($secretHash !== null) {
            return false;
        }

        $now = new DateTime();
        $validHashes = [];
        $secondsRange = 15;
        for (
            $secondsDifference = -1 * $secondsRange;
            $secondsDifference <= $secondsRange;
            $secondsDifference++
        ) {
            $datetime = clone $now;
            $datetime->modify('+' . $secondsDifference . 'seconds');
            $secretToHash = config('game.secret_key')
                . '.'
                . $datetime->format('Y-m-d H:i:s')
                . '.'
                . config('game.version');
            $validHashes[] = hash('sha256', $secretToHash);
        }

        if (in_array($request->input('secret_hash'), $validHashes)) {
            GameRequest::create([
                'secret_hash' => $request->input('secret_hash')
            ]);
            return true;
        }
        return false;
    }

    public function handleLogin(Request $request)
    {
        if (!$this->validateHash($request)) {
            $result['success'] = false;
            $result['error_message'] = 'Coś tu nie gra :)';
            return $result;
        }

        $user = User::query()
            ->where('email', '=', $request->email)
            ->first();

        if (isset($user) && Hash::check($request->password, $user->password)) {
            // logged user is banned
            if ($user->isBanned()) {
                $result['success'] = false;
                $result['error_message'] = 'Konto zostało zbanowane.';
            } else {
                // logged
                $result['success'] = true;
                $result['api_token'] = $user->api_token;
            }
        } else {
            // wrong email or password
            $result['success'] = false;
            $result['error_message'] = 'Podany przez Ciebie email lub hasło było nieprawidłowe.';
        }

        // // check if user has newest version of game
        if (!isset($request->version) || $request->version != config('game.version')) {
            $result['success'] = false;
            $result['error_message'] = 'Posiadasz nieaktualną wersję gry.';
        }

        return $result;
    }

    public function handleLoadData(Request $request)
    {
        if (!$this->validateHash($request)) {
            return response()->json([
                'reason_to_close_game' => true,
            ]);
        }

        $user = User::query()
            ->where('api_token', '=', $request->api_token)
            ->with('userGameData')
            ->first();

        return $user;
    }

    public function handleSaveData(Request $request)
    {
        if (!$this->validateHash($request)) {
            exit();
        }

        $user = User::query()
            ->where('api_token', '=', $request->api_token)
            ->first();

        if (!isset($user) || $user->user_banned == User::BANNED) {
            return response()->json([
                'reason_to_close_game' => true
            ]);
        }

        $user_game_data = UserGameData::query()
            ->where('user_id', '=', $user->id)
            ->first();

        $user_game_data->update([
            'coins' => $request->coins,
            'total_coins_earned' => $request->total_coins_earned,
            'points' => $request->points,
            'play_time_seconds' => $request->play_time_seconds,

            'games_amount' => $request->games_amount,
            'hit_wall' => $request->hit_wall,
            'hit_snake' => $request->hit_snake,
            'clicks' => $request->clicks,
            'selected_level' => $request->selected_level,

            'ate_fruits_amount' => $request->ate_fruits_amount,
            'ate_fruits_on_easy' => $request->ate_fruits_on_easy,
            'ate_fruits_on_medium' => $request->ate_fruits_on_medium,
            'ate_fruits_on_hard' => $request->ate_fruits_on_hard,
            'ate_fruits_on_speed' => $request->ate_fruits_on_speed,

            'coins_upgrade_lvl' => $request->coins_upgrade_lvl,
            'points_upgrade_lvl' => $request->points_upgrade_lvl,
            'fruits_upgrade_lvl' => $request->fruits_upgrade_lvl,

            'selected_fruits_upgrade_lvl' => $request->selected_fruits_upgrade_lvl,

            'selected_head_skin' => $request->selected_head_skin,
            'selected_body_skin' => $request->selected_body_skin,
            'selected_fruit_skin' => $request->selected_fruit_skin,
            'selected_board_skin' => $request->selected_board_skin,

            'unlocked_medium' => $request->unlocked_medium,
            'unlocked_hard' => $request->unlocked_hard,
            'unlocked_speed' => $request->unlocked_speed,

            'easy_record' => $request->easy_record,
            'medium_record' => $request->medium_record,
            'hard_record' => $request->hard_record,
            'speed_record' => $request->speed_record,

            'head_skins' => $request->head_skins,
            'body_skins' => $request->body_skins,
            'fruit_skins' => $request->fruit_skins,
            'board_skins' => $request->board_skins,

            'fps' => $request->fps,
            'music' => $request->music,
            'effects' => $request->effects,
            'volume' => $request->volume,
        ]);
    }

    public function handleOpenGameLog(Request $request)
    {
        if (!$this->validateHash($request)) {
            exit();
        }

        $user = User::query()
            ->where('api_token', '=', $request->api_token)
            ->first();

        if (isset($user)) {
            ApplicationLog::createGameAppLog(
                'game_open',
                'Użytkownik '.$user->name.' wszedł do gry.',
                $request->user_id,
                $request->ip
            );
        }
    }

    public function handleExitGameLog(Request $request)
    {
        if (!$this->validateHash($request)) {
            exit();
        }

        $user = User::query()
            ->where('api_token', '=', $request->api_token)
            ->first();

        if (isset($user)) {
            ApplicationLog::createGameAppLog(
                'game_leave',
                'Użytkownik '.$user->name.' wyszedł z gry.',
                $request->user_id,
                $request->ip
            );
        }
    }

    public function handleLogoutGameLog(Request $request)
    {
        if (!$this->validateHash($request)) {
            exit();
        }

        $user = User::query()
            ->where('api_token', '=', $request->api_token)
            ->first();

        if (isset($user)) {
            ApplicationLog::createGameAppLog(
                'game_logout',
                'Użytkownik '.$user->name.' wylogował się z gry.',
                $request->user_id,
                $request->ip
            );
        }
    }

}
