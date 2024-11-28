<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TrustLicence
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Retrieve the last checked timestamp from cache
        $lastChecked = Cache::get('license_last_checked', null);

        // Check if it's been a day since the last check
        if (!$lastChecked || now()->diffInHours($lastChecked) >= 24) {

            // Validate the license key
            $this->validateLicenseKey($request->getHost());

            // Update the last checked timestamp
            Cache::put('license_last_checked', now());
        }

        return $next($request);
    }

    /**
     * Validate the license key.
     *
     * @return bool
     */
    private function validateLicenseKey($host): bool
    {
        $currentDate = date('Y-m-d');
        $licenseKey  = config('app.license_key');
        $response    = rankWebsite()->checkLicence($host);

        if (!$response->success) {
            abort(404);
        }

        $data = (object)$response->data;

        if ($currentDate > $data->expire_date) {
            abort(401);
        }

        $isValid = $licenseKey === $data->licence_key;

        return $isValid;
    }
}
