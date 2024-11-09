<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BannedAccountMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isBanned()) {

            // logout after ban
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // redirect to login page with error message
            return redirect()->route('login')->withErrors([
                'banned' => 'Konto zostało zbanowane.'
            ]);
        }

        return $next($request);
    }
}
