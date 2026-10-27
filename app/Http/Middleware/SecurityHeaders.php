<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * SEC-HEAD-01: Add security headers to all responses.
 *
 * Headers applied here are safe for both local development and production.
 * Aggressive headers (CSP, HSTS) are intentionally omitted until full
 * dependency audit and HTTPS-only deployment are confirmed.
 */
class SecurityHeaders
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevent MIME-type sniffing — browser must respect declared Content-Type
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Prevent clickjacking — allow framing only from same origin
        // (AdminLTE internal iframes remain functional)
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Disable legacy XSS auditor (modern best practice: rely on CSP instead)
        $response->headers->set('X-XSS-Protection', '0');

        // Control referrer information sent with outgoing requests
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Restrict browser features the application does not use
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        // HSTS: Apply when connecting securely or in production (avoids breaking local HTTP)
        if ($request->isSecure() || app()->isProduction() || str_starts_with((string) config('app.url'), 'https://')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // Neutralize PHP version disclosure header if present
        $response->headers->remove('X-Powered-By');

        return $response;
    }
}
