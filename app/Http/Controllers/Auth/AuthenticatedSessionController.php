<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApplicationLog;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Services\UsersService;

class AuthenticatedSessionController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(UsersService $service)
    {
        $this->usersService = $service;
    }

    /**
     * Show login page
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Log into website
     */
    public function store(LoginRequest $request)
    {
        $user = $this->usersService->handleLoginIntoWebsite($request);

        ApplicationLog::createAppLog(
            'site_login',
            'Użytkownik '.$user->name.' zalogował się na stronę.'
        );

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        ApplicationLog::createAppLog(
            'site_logout',
            'Użytkownik '.Auth::user()->name.' wylogował się z konta na stronie.'
        );

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
