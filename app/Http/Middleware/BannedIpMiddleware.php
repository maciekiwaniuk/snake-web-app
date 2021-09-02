<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\VisitorUnique;

class BannedIpMiddleware
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
            ->where('ip_banned', '=', 1)
            ->first();

        // if current request ip found as banned ip
        if ($ip_is_banned !== null) {

            return response()
                ->view('pages.banned', [
                    'ip' => $request->getClientIp()
                ]);
        }

        return $next($request);
    }
}
