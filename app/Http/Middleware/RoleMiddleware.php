<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * @param  array<string>  $roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        if (empty($roles)) {
            return $next($request);
        }

        // Virtual role: 'authorized' grants access to any authenticated user
        if (in_array('authorized', $roles, true)) {
            return $next($request);
        }

        if (in_array($request->user()->role, $roles, true)) {
            return $next($request);
        }

        abort(403);
    }
}


