<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Models\ProcurementDirector;
use App\Services\Report\DirectorReportService;
use Illuminate\Http\Response;

class DirectorReportController extends Controller
{
    /**
     * Download a PDF report for a procurement director.
     */
    public function show(ProcurementDirector $director, DirectorReportService $directorReportService): Response
    {
        abort_unless($director->procurementProfile?->user_id === request()->user()->id, 404);

        return $directorReportService->download($director);
    }
}
