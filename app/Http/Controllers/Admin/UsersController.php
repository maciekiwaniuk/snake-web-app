<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ModifyUserDataRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\VisitorUnique;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Show users admin index page
     */
    public function index()
    {
        return view('admin.users');
    }

    /**
     * Show users admin index page with searched user
     */
    public function show($user_id)
    {
        $name = $this->getNameByUserId($user_id);

        return view('admin.users', [
            'searched_user_name' => $name
        ]);
    }

    /**
     * Return all users
     */
    public function getAllUsers()
    {
        $users = User::query()
            ->with('visitorUnique')
            ->orderBy('users.last_login_time', 'DESC')
            ->get();

        return response()->json([
            'data' => $users
        ]);
    }

    /**
     * Return all banned users
     */
    public function getBannedUsers()
    {
        $users = User::query()
            ->with('visitorUnique')
            ->where('user_banned', '=', 1)
            ->orderBy('users.last_login_time', 'DESC')
            ->get();

        return response()->json([
            'data' => $users
        ]);
    }

    /**
     * Return all not banned users
     */
    public function getNotBannedUsers()
    {
        $users = User::query()
            ->with('visitorUnique')
            ->where('user_banned', '=', 0)
            ->orderBy('users.last_login_time', 'DESC')
            ->get();

        return response()->json([
            'data' => $users
        ]);
    }

    /**
     * Ban user's last ip
     */
    public function banLastUserIP($id)
    {
        $user = $this->getUserInstanceById($id);

        $ip = $user->last_login_ip;

        $banned_ip = VisitorUnique::query()
            ->where('ip', '=', $ip)
            ->first();

        if (isset($banned_ip) && Auth::user()->last_login_ip != $banned_ip->ip) {
            $this->createAppLog(
                'ip_user_ban',
                'Administrator '.Auth::user()->name.' zbanował IP: '.$ip.' użytkownika '.$user->name.'.'
            );

            $banned_ip->ip_banned = 1;
            $banned_ip->save();

            return back()
                ->with('success', 'IP '.$banned_ip->ip.' użytkownika '.$user->name.' zostało pomyślnie zbanowane.');
        }

        return back()
            ->withErrors([
                'error' => 'Coś poszło nie tak przy banowaniu IP '.$ip.' użytkownika '.$user->name.'.'
            ]);
    }

    /**
     * Unban user's last ip
     */
    public function unbanLastUserIP($id)
    {
        $user = $this->getUserInstanceById($id);

        $ip = $user->last_login_ip;

        $banned_ip = VisitorUnique::query()
            ->where('ip', '=', $ip)
            ->first();
        $banned_ip->ip_banned = 0;
        $banned_ip->save();

        $this->createAppLog(
            'ip_user_unban',
            'Administrator '.Auth::user()->name.' odbanował IP: '.$ip.' użytkownika '.$user->name.'.'
        );

        return back()
            ->with('success', 'IP '.$banned_ip->ip.' użytkownika '.$user->name.' zostało pomyślnie odbanowane.');
    }

    /**
     * Ban user's account
     */
    public function banAccount($id)
    {
        $user = $this->getUserInstanceById($id);

        if (!$user->isAdmin()) {
            $user->user_banned = 1;
            $user->save();

            $this->createAppLog(
                'account_ban',
                'Administrator '.Auth::user()->name.' zbanował konto użytkownika '.$user->name.'.'
            );

            return back()
                ->with('success', 'Konto użytkownika '.$user->name.' zostało pomyślnie zbanowane.');
        }

        return back()
            ->withErrors([
                'error' => 'Coś poszło nie tak przy banowaniu konta użytkownika '.$user->name.'.'
            ]);
    }

    /**
     * Unban user's account
     */
    public function unbanAccount($id)
    {
        $user = $this->getUserInstanceById($id);
        $user->user_banned = 0;
        $user->save();

        $this->createAppLog(
            'account_unban',
            'Administrator '.Auth::user()->name.' odbanował konto użytkownika '.$user->name.'.'
        );

        return back()
            ->with('success', 'Konto użytkownika '.$user->name.' zostało pomyślnie odbanowane.');
    }

    /**
     * Ban user's last ip and user's account
     */
    public function banAccountAndIP($id)
    {
        $user = $this->getUserInstanceById($id);
        $user->user_banned = 1;
        $user->save();

        $this->createAppLog(
            'account_ban',
            'Administrator '.Auth::user()->name.' zbanował konto użytkownika '.$user->name.'.'
        );

        $ip = $user->last_login_ip;

        $banned_ip = VisitorUnique::query()
            ->where('ip', '=', $ip)
            ->first();

        if (Auth::user()->last_login_ip != $banned_ip->ip) {
            $this->createAppLog(
                'ip_user_ban',
                'Administrator '.Auth::user()->name.' zbanował IP: '.$ip.' użytkownika '.$user->name.'.'
            );

            $banned_ip->ip_banned = 1;
            $banned_ip->save();

            return back()
                ->with('success', 'Konto użytkownika '.$user->name.' oraz IP zostało pomyślnie zbanowane.');
        }

        return back()
            ->with('success', 'Konto użytkownika '.$user->name.' zostało pomyślnie zbanowane.');
    }

    /**
     * Unban user's last ip and user's account
     */
    public function unbanAccountAndIP($id)
    {
        $user = $this->getUserInstanceById($id);
        $user->user_banned = 0;
        $user->save();

        $ip = $user->last_login_ip;

        $banned_ip = VisitorUnique::query()
            ->where('ip', '=', $ip)
            ->first();
        $banned_ip->ip_banned = 0;
        $banned_ip->save();

        $this->createAppLog(
            'account_unban',
            'Administrator '.Auth::user()->name.' odbanował użytkownika '.$user->name.'.'
        );
        $this->createAppLog(
            'ip_user_unban',
            'Administrator '.Auth::user()->name.' odbanował IP: '.$ip.' użytkownika '.$user->name.'.'
        );

        return back()
            ->with('success', 'Konto użytkownika '.$user->name.' oraz IP zostało pomyślnie odbanowane.');
    }

    /**
     * Delete account by user's ID
     */
    public function deleteUserAccount($id)
    {
        $user_name = $this->getNameByUserId($id);

        $this->deleteUserAccountByID($id);

        return back()
            ->with('success', 'Konto użytkownika '.$user_name.' zostało usunięte pomyślnie.');
    }

    /**
     * Reset user's API Token
     */
    public function resetApiToken($id)
    {
        $user = $this->getUserInstanceById($id);
        $user->api_token = Str::random(60);
        $user->save();

        $this->createAppLog(
            'token_reset',
            'Administrator '.Auth::user()->name.' zresetował api_token użytkownika '.$user->name.'.'
        );

        return back()
            ->with('success', 'API token użytkownika '.$user->name.' zostało zresetowany pomyślnie.');
    }

    /**
     * Delete user's avatar
     */
    public function deleteAvatar($id)
    {
        $name = $this->getNameByUserId($id);
        $this->deleteUserAvatarById($id);

        $this->createAppLog(
            'avatar_delete',
            'Administrator '.Auth::user()->name.' usunął awatar użytkownika '.$name.'.'
        );

        return back()
            ->with('success', 'Awatar użytkownika '.$name.' został pomyślnie usunięty.');
    }

    /**
     * Modify user's account data
     */
    public function modifyData(ModifyUserDataRequest $request, $id)
    {
        $user = $this->getUserInstanceById($id);

        $modifiedData = [];
        if (isset($request->name)) {
            $user->name = $request->name;
            $modifiedData[] = 'nazwa';
        }

        if (isset($request->email)) {
            $user->email = $request->email;
            $modifiedData[] = 'e-mail';
        }

        if (isset($request->password)) {
            $user->password = Hash::make($request->password);
            $modifiedData[] = 'hasło';
        }

        $user->save();

        if (count($modifiedData) > 0) {
            $text = implode(', ', $modifiedData);

            $this->createAppLog(
                'user_data_modify',
                'Administrator '.Auth::user()->name.' zmodyfikował dane ('.$text.') użytkownika '.$user->name.'.'
            );

            return back()
                ->with('success', 'Dane ('.$text.') użytkownika '.$user->name.' zostały pomyślnie zmodyfikowane.');
        }

        return back()
            ->withErrors([
                'error' => 'Coś poszło nie tak przy modyfikacji danych dla użytkownika '.$user->name.'.'
            ]);
    }

}
