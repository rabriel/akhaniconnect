<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProcurementDirector;
use App\Models\User;
use App\Services\Report\DirectorReportService;
use Illuminate\Http\Response;

class DirectorReportController extends Controller
{
    /**
     * Download a director report for superadmin review.
     */
    public function show(
        User $procurementUser,
        ProcurementDirector $director,
        DirectorReportService $directorReportService
    ): Response {
        abort_unless($procurementUser->hasRole('procurement'), 404);
        abort_unless($director->procurementProfile?->user_id === $procurementUser->id, 404);

        return $directorReportService->download($director);
    }
}
