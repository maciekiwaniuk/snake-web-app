<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\VisitorUnique;

class VisitorsUniqueMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if current visitor is unique (first time on website)
        try {
            $visitor_unique = VisitorUnique::query()
                ->where('ip', '=', $request->getClientIp())
                ->firstOrFail();
        } catch (\Exception $exception) {

            VisitorUnique::create([
                'ip' => $request->getClientIp(),
                'user_agent' => substr($request->server('HTTP_USER_AGENT'), 0, 200)
            ]);
        }

        return $next($request);
    }
}
