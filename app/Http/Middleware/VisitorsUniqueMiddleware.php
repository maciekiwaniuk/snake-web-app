<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $visitor_unique = VisitorUnique::query()
            ->where('ip', '=', $request->getClientIp())
            ->first();

        // If current user is unique then add ip and user-agent to database
        if($visitor_unique === null) {
            $visitor = new VisitorUnique;
            $visitor->ip = $request->getClientIp();
            $visitor->user_agent = $request->server('HTTP_USER_AGENT');
            $visitor->save();
        }

        return $next($request);
    }
}
