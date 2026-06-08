<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Procurement\StoreDirectorRequest;
use App\Services\Procurement\ProcurementOnboardingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DirectorController extends Controller
{
    /**
     * Show the enterprise directors page.
     */
    public function index(): View
    {
        $directors = request()->user()
            ->loadMissing('procurementProfile.directors.verificationRecords')
            ->procurementProfile?->directors()
            ->latest()
            ->get() ?? collect();

        return view('procurement.directors.index', compact('directors'));
    }

    /**
     * Store a procurement director ID number for verification.
     */
    public function store(
        StoreDirectorRequest $request,
        ProcurementOnboardingService $procurementOnboardingService
    ): RedirectResponse {
        $procurementOnboardingService->addDirector($request->user(), $request->validated());

        return redirect()
            ->route('procurement.directors.index')
            ->with('status', 'Director ID number saved successfully.');
    }
}
