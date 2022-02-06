<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProfileController extends Controller
{
    /**
     * Show user's profile page
     */
    public function show($username)
    {
        try {
            $user = User::query()
                ->with('userGameData')
                ->where('name', '=', $username)
                ->firstOrFail();

            return view('pages.profile', [
                'user' => $user
            ]);
        } catch (ModelNotFoundException $e) {
            return view('pages.profile-not-found', [
                'name' => $username
            ]);
        }

    }
}
