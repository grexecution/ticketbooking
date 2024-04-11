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
        if (auth()->user() && $request->user()->google2fa_enable && !$request->user()->google2fa_authenticated) {
            return redirect()->route('2fa');
        }

        // If User is Authenticated through 2FA then proceed
        return $next($request);
    }
}
