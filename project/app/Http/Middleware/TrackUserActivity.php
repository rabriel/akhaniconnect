<?php

namespace App\Http\Middleware;

use App\Services\Analytics\UserActivityLogger;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackUserActivity
{
    public function __construct(
        protected UserActivityLogger $userActivityLogger
    ) {
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $user = $request->user();

        if ($user === null || $this->shouldSkip($request) || $request->session()->get('activity_visit_tracked', false)) {
            return $response;
        }

        $this->userActivityLogger->logRequest($user, $request, $response, 'visit');
        $request->session()->put('activity_visit_tracked', true);

        return $response;
    }

    protected function shouldSkip(Request $request): bool
    {
        $routeName = $request->route()?->getName();

        return $request->expectsJson()
            || str_starts_with($request->path(), '_debugbar')
            || in_array($routeName, ['profile.avatar.show'], true);
    }
}
