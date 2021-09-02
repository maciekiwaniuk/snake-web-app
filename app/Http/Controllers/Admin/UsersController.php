<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\VisitorUnique;


class UsersController extends Controller
{
    /**
     * Showing users admin index page
     */
    public function index()
    {
        return view('admin.users');
    }

    /**
     * Returning all users
     */
    public function getAllUsers()
    {
        // $users = User::all();
        $users = DB::select('SELECT *, users.id as user_id FROM users, visitors_unique WHERE
                             users.last_login_ip = visitors_unique.ip');

        return response()->json([
            'data' => $users
        ]);
    }

    /**
     * Returning all banned users
     */
    public function getBannedUsers()
    {
        $users = DB::select('SELECT *, users.id as user_id FROM users, visitors_unique WHERE
                             user_banned = 1
                             AND users.last_login_ip = visitors_unique.ip');

        return response()->json([
            'data' => $users
        ]);
    }

    /**
     * Returning all not banned users
     */
    public function getNotBannedUsers()
    {
        $users = DB::select('SELECT *, users.id as user_id FROM users, visitors_unique WHERE
                             user_banned = 0
                             AND users.last_login_ip = visitors_unique.ip');

        return response()->json([
            'data' => $users
        ]);
    }

    /**
     * Banning user's last ip
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
        $banned_ip->ip_banned = 1;
        $banned_ip->save();

        return back();
    }

    /**
     * Ubanning user's last ip
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

        return back();
    }

    /**
     * Banning user's account
     */
    public function banAccount($id)
    {
        $user = User::query()
            ->where('id', '=', $id)
            ->first();
        $user->user_banned = 1;
        $user->save();

        return back();
    }

    /**
     * Unbanning user's account
     */
    public function unbanAccount($id)
    {
        $user = User::query()
            ->where('id', '=', $id)
            ->first();
        $user->user_banned = 0;
        $user->save();

        return back();
    }

    /**
     * Banning user's last ip and user's account
     */
    public function banAccountAndIP($id)
    {
        $user = User::query()
            ->where('id', '=', $id)
            ->first();
        $user->user_banned = 1;
        $user->save();

        $ip = $user->last_login_ip;

        $banned_ip = VisitorUnique::query()
            ->where('ip', '=', $ip)
            ->first();
        $banned_ip->ip_banned = 1;
        $banned_ip->save();

        return back();
    }

    /**
     * Unbanning user's last ip and user's account
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

        return back();
    }

    /**
     * Deleting account by user's ID
     */
    public function deleteUserAccount($id)
    {
        $this->deleteUserAccountByID($id);

        return back();
    }
}
