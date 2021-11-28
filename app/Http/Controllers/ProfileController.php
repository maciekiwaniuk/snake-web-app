<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Show user's profile page
     */
    public function show($username)
    {
        $user = User::query()
            ->with('userGameData')
            ->where('name', '=', $username)
            ->first();

        return view('pages.profile', [
            'user' => $user
        ]);
    }
}
