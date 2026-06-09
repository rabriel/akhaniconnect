<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Procurement\StoreDirectorRequest;
use App\Models\ProcurementDirector;
use App\Services\Procurement\ProcurementOnboardingService;
use App\Services\Verification\VerificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DirectorController extends Controller
{
    /**
     * Show the enterprise directors page.
     */
    public function index(VerificationService $verificationService): View
    {
        $directors = request()->user()
            ->loadMissing('procurementProfile.directors.verificationRecords')
            ->procurementProfile?->directors()
            ->latest()
            ->get() ?? collect();

        $directors->each(function (ProcurementDirector $director) use ($verificationService): void {
            if ($director->verificationRecords->isNotEmpty() && $director->director_data === null) {
                $verificationService->syncEnterpriseDirectorFromLatestAttempt($director);
                $director->refresh();
            }
        });

        return view('procurement.directors.index', compact('directors'));
    }

    /**
     * Show a saved procurement director.
     */
    public function show(int $director, VerificationService $verificationService): View
    {
        $director = request()->user()
            ->procurementProfile?->directors()
            ->with('verificationRecords.attempts')
            ->findOrFail($director);

        if ($director->verificationRecords->isNotEmpty() && $director->director_data === null) {
            $verificationService->syncEnterpriseDirectorFromLatestAttempt($director);
            $director->refresh()->load('verificationRecords.attempts');
        }

        return view('procurement.directors.show', compact('director'));
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
