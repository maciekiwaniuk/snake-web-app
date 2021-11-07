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

        if ($current_avatar != '/assets/images/avatar.png') {
            $previous_avatar = Auth::user()->avatar;
            Storage::delete($previous_avatar);
        }

        $user = Auth::user();
        $user->avatar = '/storage/'.$folder.'/'.'avatar.'.$extension;
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
     * Checking if authorised user has admin's permision
     */
    protected function isAdmin()
    {
        if (Auth::check() && Auth::user()->permision == 2) {
            return true;
        } else {
            return false;
        }
    }
}
