<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\ClientDashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the client dashboard.
     */
    public function __invoke(Request $request, ClientDashboardService $clientDashboardService): View
    {
        return view('dashboards.client', $clientDashboardService->build());
    }
}
