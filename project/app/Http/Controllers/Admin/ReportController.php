<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\AdminReportService;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Display the admin reporting dashboard.
     */
    public function __invoke(AdminReportService $adminReportService): View
    {
        return view('admin.reports.index', $adminReportService->build());
    }
}
