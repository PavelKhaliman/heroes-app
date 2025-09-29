<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestrictGuestsMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if ($user) {
            // Restrict 'authorized' role to same as guests plus Account
            if ($user->role === 'authorized') {
                $isGet = $request->isMethod('GET');
                $isPost = $request->isMethod('POST');

                $allowed = (
                    ($isGet && (($request->is('/') || $request->is('')) || $request->is('link') || $request->is('account')))
                    || ($isPost && $request->is('logout'))
                    || $request->is('media/*') || $request->is('build/*') || $request->is('assets/*') || $request->is('favicon.ico')
                );

                if ($allowed) {
                    return $next($request);
                }

                return redirect()->route('account.index');
            }

            return $next($request);
        }

        // Allow-list by path (global middleware runs before route resolution)
        $isGet = $request->isMethod('GET');
        $isPost = $request->isMethod('POST');

        $allowed = (
            // Pages allowed for guests
            ($isGet && (
                ($request->is('/') || $request->is(''))
                || $request->is('link')
                || $request->is('login')
                || $request->is('register')
                || $request->is('clan')
                || $request->is('clan/regulation')
                || $request->is('clan/coslist')
                || $request->is('clan/application')
            ))
            // Login submit / Register submit / Clan application submit
            || ($isPost && (
                $request->is('login')
                || $request->is('register')
                || $request->is('clan/application')
            ))
            // Media and static assets
            || $request->is('media/*')
            || $request->is('build/*')
            || $request->is('assets/*')
            || $request->is('favicon.ico')
        );

        if ($allowed) {
            return $next($request);
        }

        return redirect()->route('login');
    }
}


