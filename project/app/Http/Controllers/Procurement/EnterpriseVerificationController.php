<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Services\Procurement\ProcurementOnboardingService;
use App\Services\Verification\VerificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EnterpriseVerificationController extends Controller
{
    /**
     * Submit enterprise verification for the procurement registration number.
     */
    public function store(
        Request $request,
        VerificationService $verificationService,
        ProcurementOnboardingService $procurementOnboardingService
    ): RedirectResponse {
        $user = $request->user();
        $savedRegistrationNumber = $user->procurementProfile?->registration_number;

        if ($request->filled('registration_number')) {
            $validated = $request->validate([
                'registration_number' => ['required', 'string', 'max:50'],
            ]);

            $procurementOnboardingService->updateEnterpriseDetails($user, $validated);
        } elseif (blank($savedRegistrationNumber)) {
            return redirect()
                ->route('procurement.enterprise.edit')
                ->with('error', 'Enter a registration number before running enterprise verification.');
        }

        $record = $verificationService->verifyEnterprise($user);
        $procurementOnboardingService->refreshVerificationProgress($user);

        if ($record->status !== 'verified') {
            return redirect()
                ->route('procurement.enterprise.edit')
                ->with('error', $record->last_error ?: 'Enterprise verification failed. Please try again.');
        }

        return redirect()
            ->route('procurement.enterprise.edit')
            ->with('status', 'CIPC enterprise verification completed and enterprise data has been refreshed.');
    }
}
