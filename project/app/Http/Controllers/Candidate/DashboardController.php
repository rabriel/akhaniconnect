<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Services\Candidate\CandidateDashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the candidate dashboard.
     */
    public function __invoke(Request $request, CandidateDashboardService $candidateDashboardService): View
    {
        $dashboard = $candidateDashboardService->build($request->user());

        return view('dashboards.candidate', $dashboard);
    }
}
