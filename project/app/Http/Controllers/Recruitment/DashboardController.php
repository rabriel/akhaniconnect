<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Services\Recruitment\RecruitmentDashboardService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the recruitment dashboard.
     */
    public function __invoke(Request $request, RecruitmentDashboardService $recruitmentDashboardService): View
    {
        $dashboard = $recruitmentDashboardService->build($request->user());

        return view('dashboards.recruitment', $dashboard);
    }
}
