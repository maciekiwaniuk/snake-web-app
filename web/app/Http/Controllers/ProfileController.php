<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;

class ProfileController extends Controller
{
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
