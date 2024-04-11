<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if there's a session variable indicating to skip 2FA (added by superuser)
        if ($request->session()->has('skip2fa')) {
            return $next($request);
        }

        // If 2FA is enabled need to enter one time code from email
        if (auth()->user() && $request->user()->google2fa_enable && !$request->user()->google2fa_authenticated) {
            return redirect()->route('2fa');
        }

        // If User is Authenticated through 2FA then proceed
        return $next($request);
    }
}
