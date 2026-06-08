<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Models\ProcurementDirector;
use App\Services\Procurement\ProcurementOnboardingService;
use App\Services\Verification\VerificationService;
use Illuminate\Http\RedirectResponse;

class DirectorVerificationController extends Controller
{
    /**
     * Submit director verification for the selected director ID number.
     */
    public function store(
        ProcurementDirector $director,
        VerificationService $verificationService,
        ProcurementOnboardingService $procurementOnboardingService
    ): RedirectResponse {
        abort_unless($director->procurementProfile?->user_id === request()->user()->id, 404);

        $verificationService->verifyEnterpriseDirector(request()->user(), $director);
        $procurementOnboardingService->refreshVerificationProgress(request()->user());

        return redirect()
            ->route('procurement.directors.index')
            ->with('status', 'Enterprise director verification completed and director data has been refreshed.');
    }
}
