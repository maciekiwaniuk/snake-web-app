<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\VisitorUnique;


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
        $user = User::query()
            ->where('id', '=', $id)
            ->first();

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
        }

        return back();
    }

    /**
     * Unban user's last ip
     */
    public function unbanLastUserIP($id)
    {
        $user = User::query()
            ->where('id', '=', $id)
            ->first();

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

        return back();
    }

    /**
     * Ban user's account
     */
    public function banAccount($id)
    {
        $user = User::query()
            ->where('id', '=', $id)
            ->first();
        $user->user_banned = 1;
        $user->save();

        $this->createAppLog(
            'account_ban',
            'Administrator '.Auth::user()->name.' zbanował użytkownika '.$user->name.'.'
        );

        return back();
    }

    /**
     * Unban user's account
     */
    public function unbanAccount($id)
    {
        $user = User::query()
            ->where('id', '=', $id)
            ->first();
        $user->user_banned = 0;
        $user->save();

        $this->createAppLog(
            'account_unban',
            'Administrator '.Auth::user()->name.' odbanował użytkownika '.$user->name.'.'
        );

        return back();
    }

    /**
     * Ban user's last ip and user's account
     */
    public function banAccountAndIP($id)
    {
        $user = User::query()
            ->where('id', '=', $id)
            ->first();
        $user->user_banned = 1;
        $user->save();

        $this->createAppLog(
            'account_ban',
            'Administrator '.Auth::user()->name.' zbanował użytkownika '.$user->name.'.'
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
        }

        return back();
    }

    /**
     * Unban user's last ip and user's account
     */
    public function unbanAccountAndIP($id)
    {
        $user = User::query()
            ->where('id', '=', $id)
            ->first();
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

        return back();
    }

    /**
     * Delete account by user's ID
     */
    public function deleteUserAccount($id)
    {
        $this->deleteUserAccountByID($id);

        return back();
    }

    /**
     * Reset user's API Token
     */
    public function resetApiToken($id)
    {
        $user = User::query()
            ->where('id', '=', $id)
            ->first();
        $user->api_token = Str::random(60);
        $user->save();

        $this->createAppLog(
            'token_reset',
            'Administrator '.Auth::user()->name.' zresetował api_token użytkownika '.$user->name.'.'
        );

        return back();
    }
}
