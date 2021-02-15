<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AcceptOnlyAdmin
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
        if (Auth::guest()) {
            return abort(Response::HTTP_NOT_FOUND);
        } elseif (Auth::user()->is_admin === 0) {
            return abort(Response::HTTP_NOT_FOUND);
        } else {
            return $next($request);
        }
    }
}
