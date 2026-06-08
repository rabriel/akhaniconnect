<?php

namespace App\Http\Controllers;

use App\Services\Auth\LoginRedirectService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Redirect the authenticated user to the correct role dashboard.
     */
    public function __invoke(Request $request, LoginRedirectService $loginRedirectService): RedirectResponse
    {
        return redirect()->route($loginRedirectService->resolveDashboardRouteName($request->user()));
    }
}
