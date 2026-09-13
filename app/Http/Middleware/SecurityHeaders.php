<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request and attach strong HTTP security headers.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevent Clickjacking attacks
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Prevent MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Enable legacy browser XSS filtering
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer policy for strict privacy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Restrict sensitive browser APIs by default
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        // Hide server PHP technology fingerprint
        $response->headers->remove('X-Powered-By');

        return $response;
    }
}
