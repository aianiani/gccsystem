<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecureHeaders
{
    /**
     * Handle an incoming request and add secure security headers.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Mitigate SEC-02: Missing Anti-clickjacking Header
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Mitigate SEC-07: X-Content-Type-Options Header Missing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // XSS Protection (for older browsers)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer Policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Mitigate SEC-06: Strict-Transport-Security (HSTS) Header Not Set
        // Only enforce this if the request is secure (HTTPS) or running in production
        if ($request->isSecure() || config('app.env') === 'production') {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        // Mitigate SEC-01: Content Security Policy (CSP) Header Not Set
        // This policy allows local resources and common CDNs/Fonts securely without breaking Vite or styling
        $response->headers->set('Content-Security-Policy', "default-src 'self' 'unsafe-inline' 'unsafe-eval' https: data:; object-src 'none'; base-uri 'self';");

        // Mitigate SEC-05: Server Leaks Information via 'X-Powered-By' HTTP Response Header
        $response->headers->remove('X-Powered-By');
        if (function_exists('header_remove')) {
            header_remove('X-Powered-By');
        }

        return $response;
    }
}
