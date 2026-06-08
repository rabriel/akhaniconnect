<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Services\Procurement\ProcurementOnboardingService;
use App\Services\Verification\VerificationService;
use Illuminate\Http\RedirectResponse;

class EnterpriseVerificationController extends Controller
{
    /**
     * Submit enterprise verification for the saved procurement registration number.
     */
    public function store(
        VerificationService $verificationService,
        ProcurementOnboardingService $procurementOnboardingService
    ): RedirectResponse {
        $verificationService->verifyEnterprise(request()->user());
        $procurementOnboardingService->refreshVerificationProgress(request()->user());

        return redirect()
            ->route('procurement.enterprise.edit')
            ->with('status', 'CIPC enterprise verification completed and enterprise data has been refreshed.');
    }
}
