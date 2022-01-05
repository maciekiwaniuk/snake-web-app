<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class TotalVisitsAmountMiddleware
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
            if (Redis::get('total_visits_amount') === null) {
                Redis::set('total_visits_amount', 0);
            }

            Redis::set('total_visits_amount', Redis::get('total_visits_amount') + 1);
        }

        return $next($request);
    }
}
