<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\VisitorUnique;


class UsersActionsController extends Controller
{
    /**
     * Banning ip
     */
    public function banIP($id)
    {
        $user = User::query()
            ->where('id', '=', $id)
            ->first();
        $user->banned = 1;
        $user->save();

        $ip = $user->last_login_ip;

        $banned_ip = VisitorUnique::query()
            ->where('ip', '=', $ip)
            ->first();
        $banned_ip->banned = 1;
        $banned_ip->save();

        return back();
    }

    /**
     * Deleting selected user's account
     */
    public function deleteUserAccount($id)
    {
        $this->deleteUserAccountByID($id);

        return back();
    }
}
