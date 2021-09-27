<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserDeleted;
use App\Models\UserGameData;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Returning bool on user's permision
     * to do something, true when:
     *  - if user_id == Auth::user()->id
     *  - Auth::user()->permision = 2 (ADMIN)
     */
    protected function hasPermision($user_id)
    {
        if (Auth::user()->id == $user_id || Auth::user()->permision == 2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Searching for user by his name
     */
    protected function findUserByUsername($username)
    {
        $user = User::query()
            ->where('name', '=', $username)
            ->first();

        if(!isset($user)) return abort(404);

        return $user;
    }

    /**
     * Function that:
     * - adding user's avatar
     * - deleting previous user's avatar
     * - saving link to user's avatar in database
     */
    protected function changeUserAvatar($image)
    {
        $extension = $image->getClientOriginalExtension();

        $filename = 'avatar.'.$extension;
        $folder = 'users_avatars/'.Auth::user()->name;

        $image->storeAs($folder, $filename, 'public');

        $current_avatar = explode('/', Auth::user()->avatar);

        if ($current_avatar != 'assets/images/avatar.png') {
            $previous_avatar = Auth::user()->avatar;
            Storage::delete($previous_avatar);
        }

        $user = Auth::user();
        $user->avatar = 'storage/'.$folder.'/'.'avatar.'.$extension;
        $user->save();
    }

    /**
     * Deleting user's avatar and replacing
     * it with default.png
     */
    protected function deleteUserAvatar()
    {
        if (Auth::user()->avatar != 'assets/images/avatar.png') {
            $previous_avatar = Auth::user()->avatar;
            Storage::delete($previous_avatar);

            $user = Auth::user();
            $user->avatar = 'assets/images/avatar.png';
            $user->save();
        }
    }

    /**
     * Deleting user's account by his id
     * and adding data about user to users_deleted table
     */
    protected function deleteUserAccountByID($user_id)
    {
        $user = User::query()
            ->where('id', '=', $user_id)
            ->first();
        $user_deleted = new UserDeleted;

        $user_deleted->name =        $user->name;
        $user_deleted->email =       $user->email;
        $user_deleted->previous_id = $user->id;
        $user_deleted->last_ip =     $user->last_login_ip;
        $user_deleted->last_date =   $user->last_login_time;
        $user_deleted->created_at =  $user->created_at;

        $user_deleted->save();
        $user->delete();
    }

    /**
     * Adding user's game data to database
     * with relation hasMany
     * users.id <==> users_game_data.user_id
     */
    protected function insertGameDataToDatabase($content, $filename)
    {
        $user_game_data = new UserGameData;

        $user_game_data->user_id = Auth::user()->id;
        $user_game_data->filename = $filename;

        $user_game_data->coins = $content['coins'];
        $user_game_data->selected_level = $content['selected_level'];
        $user_game_data->selected_skins_snake = $content['selected_skins']['snake'];
        $user_game_data->selected_skins_fruit = $content['selected_skins']['fruit'];
        $user_game_data->selected_skins_board = $content['selected_skins']['board'];
        $user_game_data->difficulties_medium = $content['difficulties']['medium'];
        $user_game_data->difficulties_hard = $content['difficulties']['hard'];
        $user_game_data->records_easy = $content['records']['easy'];
        $user_game_data->records_medium = $content['records']['medium'];
        $user_game_data->records_hard = $content['records']['hard'];

        $user_game_data->inventory_snake_skins = implode(',', $content['inventory']['snake_skins']);
        $user_game_data->inventory_fruit_skins = implode(',', $content['inventory']['fruit_skins']);
        $user_game_data->inventory_board_skins = implode(',', $content['inventory']['board_skins']);

        $user_game_data->options_fps = $content['options']['fps'];
        $user_game_data->options_music = $content['options']['music'];
        $user_game_data->options_effects = $content['options']['effects'];
        $user_game_data->options_volume = $content['options']['volume'];

        $user_game_data->save();
    }

    /**
     * Returning valid game data ready
     * to upload in game, when parameter
     * is data from database *game_user_data*
     */
    protected function getValidGameData($progress)
    {
        $content = [];
        $content['coins'] = $progress->coins;
        $content['selected_level'] = $progress->selected_level;
        $content['selected_skins']['snake'] = $progress->selected_skins_snake;
        $content['selected_skins']['fruit'] = $progress->selected_skins_fruit;
        $content['selected_skins']['board'] = $progress->selected_skins_board;
        $content['difficulties']['medium'] = $progress->difficulties_medium;
        $content['difficulties']['hard'] = $progress->difficulties_hard;
        $content['records']['easy'] = $progress->records_easy;
        $content['records']['medium'] = $progress->records_medium;
        $content['records']['hard'] = $progress->records_hard;
        $content['inventory']['snake_skins'] = explode(',', $progress->inventory_snake_skins);
        $content['inventory']['fruit_skins'] = explode(',', $progress->inventory_fruit_skins);
        $content['inventory']['board_skins'] = explode(',', $progress->inventory_board_skins);
        $content['options']['fps'] = $progress->options_fps;
        $content['options']['music'] = $progress->options_music;
        $content['options']['effects'] = $progress->options_effects;
        $content['options']['volume'] = $progress->options_volume;

        $content = json_encode($content);

        return $content;
    }
}
