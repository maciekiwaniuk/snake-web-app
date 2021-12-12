<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Request as RequestFacade;
use App\Models\User;
use App\Models\UserDeleted;
use App\Models\AppLog;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Return bool on user's permission
     * to do something
     */
    protected function hasPermission($user_id)
    {
        if (Auth::user()->id == $user_id || Auth::user()->isAdmin()) {
            return true;
        }
        return false;
    }

    /**
     * Search for user by his name and return instance of user
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
     * Add user's avatar, delete previous user's avatar
     * and save link to user's avatar in database
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
     * Delete current logged user's avatar and replace
     * it with default
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
     * Find user by id and then delete his avatar and
     * replace it with default
     */
    protected function deleteUserAvatarById($user_id)
    {
        $user = $this->getUserInstanceById($user_id);

        if ($user->avatar != '/assets/images/avatar.png') {
            $previous_avatar = $user->avatar;
            Storage::delete($previous_avatar);

            $user->avatar = '/assets/images/avatar.png';
            $user->save();
        }
    }

    /**
     * Delete user's account by his id
     * and add data about user to users_deleted table
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
     * Check if authorised user has admin's permission
     */
    protected function isAdmin()
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return true;
        }
        return false;
    }

    /**
     * Create app log
     */
    protected function createAppLog($type, $content)
    {
        $log = new AppLog;

        $log->type = $type;
        $log->content = $content;
        $log->user_id = Auth::user()->id;
        $log->ip = RequestFacade::ip();

        $log->save();
    }

    /**
     * Create app log for game actions
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

    /**
     * Return user's name by id
     */
    protected function getNameByUserId($id)
    {
        $user = User::query()
            ->where('id', '=', $id)
            ->first();
        return $user->name;
    }

    /**
     * Return user instance by id
     */
    protected function getUserInstanceById($id)
    {
        $user = User::query()
            ->where('id', '=', $id)
            ->first();
        return $user;
    }
}
