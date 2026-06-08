<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Procurement\UpdatePersonalDetailsRequest;
use App\Services\Procurement\ProcurementOnboardingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the procurement personal details form.
     */
    public function edit(): View
    {
        return view('procurement.profile.edit');
    }

    /**
     * Update the procurement personal details.
     */
    public function update(
        UpdatePersonalDetailsRequest $request,
        ProcurementOnboardingService $procurementOnboardingService
    ): RedirectResponse {
        $procurementOnboardingService->updatePersonalDetails($request->user(), $request->validated());

        return redirect()
            ->route('procurement.profile.edit')
            ->with('status', 'Personal details saved successfully.');
    }
}
