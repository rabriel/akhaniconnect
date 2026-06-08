<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminDashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the superadmin dashboard.
     */
    public function __invoke(AdminDashboardService $adminDashboardService): View
    {
        return view('dashboards.admin', $adminDashboardService->build());
    }
}
