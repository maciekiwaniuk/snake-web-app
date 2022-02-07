<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterAccountRequest;
use App\Providers\RouteServiceProvider;
use App\Services\UsersService;
use App\Helpers\ApplicationLog;

class RegisteredUserController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(UsersService $service)
    {
        $this->usersService = $service;
    }

    /**
     * Show register page
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store new user account
     */
    public function store(RegisterAccountRequest $request)
    {
        $user = $this->usersService->handleRegisterAccount($request);

        ApplicationLog::createAppLog(
            'site_register',
            'Użytkownik '.$user->name.' utworzył konto.'
        );

        return redirect(RouteServiceProvider::HOME);
    }
}
