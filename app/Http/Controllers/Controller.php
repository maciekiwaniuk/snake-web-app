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
        $user->update([
            'avatar' => '/storage/'.$folder.'/'.'avatar.'.$extension
        ]);
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
            $user->update([
                'avatar' => '/assets/images/avatar.png'
            ]);
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

            $user->update([
                'avatar' => '/assets/images/avatar.png'
            ]);
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
        UserDeleted::create([
            'name' => $user->name,
            'password' => $user->password,
            'email' => $user->email,
            'previous_id' => $user->id,
            'last_login_ip' => $user->last_login_ip,
            'last_login_time' => $user->last_login_time,
            'created_at' => $user->created_at,
        ]);

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
        AppLog::create([
            'type' => $type,
            'content' => $content,
            'user_id' => Auth::user()->id,
            'ip' => RequestFacade::ip()
        ]);
    }

    /**
     * Create app log for game actions
     */
    protected function createGameAppLog($type, $content, $user_id, $ip)
    {
        AppLog::create([
            'type' => $type,
            'content' => $content,
            'user_id' => $user_id,
            'ip' => $ip
        ]);
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
