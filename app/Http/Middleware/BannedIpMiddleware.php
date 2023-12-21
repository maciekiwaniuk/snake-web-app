<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\VisitorUnique;

class BannedIpMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $ip = VisitorUnique::query()
                    ->where('ip', '=', $request->getClientIp())
                    ->where('ip_banned', '=', VisitorUnique::BANNED)
                    ->firstOrFail();

            return response()
                ->view('pages.banned', [
                    'ip' => $request->getClientIp()
                ]);
        } catch (\Exception $exception) {
            //
        }

        return $next($request);
    }
}
