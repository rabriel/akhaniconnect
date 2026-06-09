<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Services\Procurement\ProcurementOnboardingService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the procurement dashboard.
     */
    public function __invoke(ProcurementOnboardingService $procurementOnboardingService): View
    {
        $user = request()->user()->loadMissing(['profile', 'procurementProfile.directors', 'verificationRecords']);
        $procurementOnboardingService->refreshVerificationProgress($user);
        $user = $user->fresh(['profile', 'procurementProfile.directors', 'verificationRecords']);
        $steps = $procurementOnboardingService->getDashboardSteps($user);
        $progress = $user->procurementProfile?->verification_progress ?? 0;

        return view('dashboards.procurement', compact('steps', 'progress', 'user'));
    }
}
