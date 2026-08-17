<?php

namespace App\Http\Middleware;

use App\Services\Privacy\PrivacyAcknowledgementService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePopiaAcknowledged
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return $next($request);
        }

        if ($request->session()->get(PrivacyAcknowledgementService::SESSION_KEY) === true) {
            return $next($request);
        }

        return redirect()
            ->route('popia.notice.show')
            ->with('error', 'Please acknowledge the POPIA notice before continuing.');
    }
}
