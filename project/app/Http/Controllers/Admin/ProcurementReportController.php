<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Report\ProcurementReportService;
use Illuminate\Http\Response;

class ProcurementReportController extends Controller
{
    /**
     * Download a procurement report for superadmin review.
     */
    public function show(User $procurementUser, ProcurementReportService $procurementReportService): Response
    {
        abort_unless($procurementUser->hasRole('procurement'), 404);

        return $procurementReportService->download($procurementUser);
    }
}
