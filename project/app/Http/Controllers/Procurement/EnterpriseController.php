<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Procurement\UpdateEnterpriseDetailsRequest;
use App\Services\Procurement\ProcurementOnboardingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class EnterpriseController extends Controller
{
    /**
     * Show the enterprise details form.
     */
    public function edit(): View
    {
        $user = request()->user()->loadMissing(['procurementProfile', 'verificationRecords.attempts']);
        $record = $user->verificationRecords->where('module', 'enterprise')->first();

        return view('procurement.enterprise.edit', compact('record'));
    }

    /**
     * Update enterprise details.
     */
    public function update(
        UpdateEnterpriseDetailsRequest $request,
        ProcurementOnboardingService $procurementOnboardingService
    ): RedirectResponse {
        $procurementOnboardingService->updateEnterpriseDetails($request->user(), $request->validated());

        return redirect()
            ->route('procurement.enterprise.edit')
            ->with('status', 'Enterprise information saved successfully.');
    }
}
