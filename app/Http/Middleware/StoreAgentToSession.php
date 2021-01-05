<?php

namespace App\Http\Middleware;

use Closure;
use Jenssegers\Agent\Agent;

class StoreAgentToSession
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $agent = new Agent();
        if ($agent->isMobile()) {
            $request->session()->put(['agent' => 'mobile']);
        } else {
            $request->session()->put(['agent' => 'desktop']);
        }

        return $next($request);
    }
}
