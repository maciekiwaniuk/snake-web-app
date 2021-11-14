<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\AppLog;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        // saving user's ip and login's time
        $user = Auth::user();
        $user->last_login_ip = $request->getClientIp();
        $user->last_login_time = Carbon::now()->toDateTimeString();
        $user->last_user_agent = $request->server('HTTP_USER_AGENT');
        $user->save();

        if (Auth::user()->user_banned && Auth::user()->isUser()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors([
                'banned' => 'Konto na które próbujesz się zalogować zostało zbanowane.'
            ]);
        }

        $this->createAppLog(
            "site_login",
            "Użytkownik ".$user->name." zalogował się na stronę."
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
        $this->createAppLog(
            "site_logout",
            "Użytkownik ".Auth::user()->name." wylogował się z konta na stronie."
        );

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
