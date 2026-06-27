<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class EnsureCartSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->cookie('cart_session')) {

            $sessionId = Str::uuid()->toString();

            cookie()->queue(
                cookie('cart_session', $sessionId, 60 * 24 * 30)
            );
        }

        return $next($request);    
    }
}
