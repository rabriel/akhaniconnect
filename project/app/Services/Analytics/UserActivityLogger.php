<?php

namespace App\Services\Analytics;

use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserActivityLogger
{
    public function __construct(
        protected UserAgentParser $userAgentParser,
        protected GeoLocationResolver $geoLocationResolver
    ) {
    }

    /**
     * Store an activity record for an authenticated user request.
     */
    public function logRequest(User $user, Request $request, Response $response, string $activityType = 'page_view'): void
    {
        $userAgent = (string) $request->userAgent();
        $agentDetails = $this->userAgentParser->parse($userAgent);
        $location = $this->geoLocationResolver->resolve($request->ip(), [
            'CF-IPCountry' => $request->header('CF-IPCountry'),
            'X-Appengine-Country' => $request->header('X-Appengine-Country'),
            'X-Country-Code' => $request->header('X-Country-Code'),
        ]);

        UserActivity::query()->create([
            'user_id' => $user->id,
            'activity_type' => $activityType,
            'method' => $request->method(),
            'route_name' => $request->route()?->getName(),
            'path' => '/' . ltrim($request->path(), '/'),
            'ip_address' => $request->ip(),
            'country_code' => $location['country_code'],
            'country_name' => $location['country_name'],
            'browser' => $agentDetails['browser'],
            'platform' => $agentDetails['platform'],
            'device_type' => $agentDetails['device_type'],
            'response_status' => $response->getStatusCode(),
            'user_agent' => $userAgent,
            'metadata' => [
                'full_url' => $request->fullUrl(),
                'query' => $request->query(),
            ],
            'occurred_at' => now(),
        ]);
    }
}
