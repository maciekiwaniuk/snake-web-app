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
        if (env('REDIS_CONFIGURED')) {
            if (Redis::get('welcome_page_visits_amount') === null) {
                Redis::set('welcome_page_visits_amount', 0);
            }

            Redis::set('welcome_page_visits_amount', Redis::get('welcome_page_visits_amount') + 1);
        }

        return $next($request);
    }
}
