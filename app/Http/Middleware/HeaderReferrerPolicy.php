<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HeaderReferrerPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $response->header('Referrer-Policy', 'origin-when-cross-origin');
        return $response;
    }
}
