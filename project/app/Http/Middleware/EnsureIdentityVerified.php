<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIdentityVerified
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user === null) {
            abort(403);
        }

        if (! $user->hasRole('candidate') && ! $user->hasRole('client') && ! $user->hasRole('recruitment') && ! $user->hasRole('procurement')) {
            return $next($request);
        }

        if ($user->hasVerifiedIdentity()) {
            return $next($request);
        }

        $route = match (true) {
            $user->hasRole('candidate') => 'candidate.identity-verification.show',
            $user->hasRole('client') => 'client.identity-verification.show',
            $user->hasRole('recruitment') => 'recruitment.identity-verification.show',
            $user->hasRole('procurement') => 'procurement.identity-verification.show',
            default => null,
        };

        if ($route === null) {
            abort(403);
        }

        return redirect()
            ->route($route)
            ->with('error', 'You need to verify your ID to proceed.');
    }
}
