<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Request;
use App\Models\User;
use App\Models\UserDeleted;
use App\Models\AppLog;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Returning bool on user's permission
     * to do something, true when:
     *  - if user_id == Auth::user()->id
     *  - Auth::user()->permission = 2 (ADMIN)
     */
    protected function hasPermission($user_id)
    {
        if (Auth::user()->id == $user_id || Auth::user()->isAdmin()) {
            return true;
        }
        return false;
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
        $folder = '/users_avatars/'.Auth::user()->name;

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
        if (Auth::user()->avatar != '/assets/images/avatar.png') {
            $previous_avatar = Auth::user()->avatar;
            Storage::delete($previous_avatar);

            $user = Auth::user();
            $user->avatar = '/assets/images/avatar.png';
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
        $user_deleted->password =    $user->password;
        $user_deleted->email =       $user->email;
        $user_deleted->previous_id = $user->id;
        $user_deleted->last_ip =     $user->last_login_ip;
        $user_deleted->last_date =   $user->last_login_time;
        $user_deleted->created_at =  $user->created_at;

        if (Auth::user()->isAdmin()) {
            $this->createAppLog(
                'account_delete',
                'Administrator '.Auth::user()->name.' usunął konto użytkownika '.$user->name.'.'
            );
        } else {
            $this->createAppLog(
                'account_delete',
                'Konto użytkownika '.$user->name.' zostało usunięte manualnie.'
            );
        }

        $user_deleted->save();
        $user->delete();
    }

    /**
     * Checking if authorised user has admin's permission
     */
    protected function isAdmin()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return true;
        }
        return false;
    }

    /**
     * Creating app log
     */
    protected function createAppLog($type, $content)
    {
        $log = new AppLog;

        $log->type = $type;
        $log->content = $content;
        $log->user_id = Auth::user()->id;
        $log->ip = Request::ip();

        $log->save();
    }

    /**
     * Creating app log for game actions
     */
    protected function createGameAppLog($type, $content, $user_id, $ip)
    {
        $log = new AppLog;

        $log->type = $type;
        $log->content = $content;
        $log->user_id = $user_id;
        $log->ip = $ip;

        $log->save();
    }
}
