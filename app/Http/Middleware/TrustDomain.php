<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Symfony\Component\HttpFoundation\Response;

class TrustDomain
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Define allowed domains
        $allowedDomains = [
            'localhost',
            '192.168.68.56',
            'devzetstudio.com',
            'activelinkers.com',
            'www.activelinkers.com'
        ];

        // Get the current domain
        $currentDomain = $request->getHost();

        // Check if the current domain is in the allowed list
        if (!in_array($currentDomain, $allowedDomains)) {
            return response()->json([], 401);
        }

        return $next($request);
    }
}
