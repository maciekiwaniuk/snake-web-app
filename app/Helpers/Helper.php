<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\VisitorUnique;

class Helper
{
    /**
     * Get user instance by user_id
     */
    public static function getUserInstanceById($user_id)
    {
        $user = User::query()
            ->where('id', '=', $user_id)
            ->first();
        return $user;
    }

    /**
     * Get user instance by username
     */
    public static function getUserInstanceByUsername($username)
    {
        $user = User::query()
            ->where('name', '=', $username)
            ->first();

        if(!isset($user)) return abort(404);

        return $user;
    }

    /**
     * Get username by id
     */
    public static function getUsernameById($user_id)
    {
        $user = User::query()
            ->where('id', '=', $user_id)
            ->first();
        return $user->name;
    }

    /**
     * Get visitor unique (unique IP) instance by id
     */
    public static function getVisitorUniqueById($ip_id)
    {
        $ip = VisitorUnique::query()
            ->where('id', '=', $ip_id)
            ->first();
        return $ip;
    }


}
