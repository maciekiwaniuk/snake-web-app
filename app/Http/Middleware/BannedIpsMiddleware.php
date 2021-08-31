<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\VisitorUnique;

class BannedIpsMiddleware
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
        $ip_is_banned = VisitorUnique::query()
            ->where('ip', '=', $request->getClientIp())
            ->where('banned', '=', 1)
            ->first();

        if ($ip_is_banned !== null) {
            return response()
                ->view('pages.banned', [
                    'ip' => $request->getClientIp()
                ]);
        }

        return $next($request);
    }
}
