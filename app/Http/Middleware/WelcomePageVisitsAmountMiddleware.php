<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class WelcomePageVisitsAmountMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $key = 'welcome_page_visits_amount_'.env('APP_ENV');

        if (env('REDIS_CONFIGURED')) {
            if (Redis::get($key) === null) {
                Redis::set($key, 0);
            }

            Redis::set($key, Redis::get($key) + 1);
        }

        return $next($request);
    }
}
