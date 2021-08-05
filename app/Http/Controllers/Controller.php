<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Funkcja wyszukująca użytkownika
     * po jego nazwie
     */
    public function findUserByUsername($username)
    {
        $user = User::query()
            ->where('name', '=', $username)
            ->first();

        if(!isset($user)) return abort(404);

        return $user;
    }
}
