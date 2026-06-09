<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Services\Report\EnterpriseReportService;
use Illuminate\Http\Response;

class EnterpriseReportController extends Controller
{
    /**
     * Download a PDF report for the authenticated procurement enterprise.
     */
    public function show(EnterpriseReportService $enterpriseReportService): Response
    {
        $profile = request()->user()->procurementProfile;
        abort_if($profile === null, 404);

        return $enterpriseReportService->download($profile);
    }
}
