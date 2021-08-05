<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NoMimeSniffingMiddleware
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
        $response->header('X-Content-Type-Options', 'nosniff');
        return $response;
    }
}
