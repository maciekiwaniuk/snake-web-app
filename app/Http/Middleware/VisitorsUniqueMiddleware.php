<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\VisitorUnique;

class VisitorsUniqueMiddleware
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
        // Check if current visitor is unique (first time on website)
        try {
            $visitor_unique = VisitorUnique::query()
                ->where('ip', '=', $request->getClientIp())
                ->firstOrFail();
        } catch (\Exception) {

            $visitor = new VisitorUnique;
            $visitor->ip = $request->getClientIp();
            $visitor->user_agent = $request->server('HTTP_USER_AGENT');
            $visitor->save();
        }

        return $next($request);
    }
}
