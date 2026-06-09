<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Report\EnterpriseReportService;
use Illuminate\Http\Response;

class EnterpriseReportController extends Controller
{
    /**
     * Download an enterprise report for client review.
     */
    public function show(User $procurementUser, EnterpriseReportService $enterpriseReportService): Response
    {
        abort_unless($procurementUser->hasRole('procurement'), 404);
        abort_if($procurementUser->procurementProfile === null, 404);

        return $enterpriseReportService->download($procurementUser->procurementProfile);
    }
}
