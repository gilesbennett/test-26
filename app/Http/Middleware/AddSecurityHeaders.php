<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Vite;
use Symfony\Component\HttpFoundation\Response;

class AddSecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->isLocal()) {
            return $next($request);
        }
        Vite::useCspNonce();
        $nonce = Vite::cspNonce();
        $response = $next($request);
        $response->headers->add([
            'Content-Security-Policy' => implode('; ', [
                "default-src 'self'",
                "script-src 'self' 'nonce-{$nonce}'",
                "style-src 'self' 'nonce-{$nonce}'",
                "img-src 'self' https://rickandmortyapi.com",
                "object-src 'none'",
                "base-uri 'self'",
                "form-action 'self'",
                "frame-ancestors 'none'",
            ]),
            'X-Content-Type-Options' => 'nosniff',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Permissions-Policy' => 'camera=(), microphone=(), geolocation=()',
        ]);

        return $response;
    }
}
