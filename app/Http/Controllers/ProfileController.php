<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Wyświetlenie profilu użytkownika
     */
    public function show($username)
    {
        $user = $this->findUserByUsername($username);

        return view('pages.profile', [
            'user' => $user
        ]);
    }
}
