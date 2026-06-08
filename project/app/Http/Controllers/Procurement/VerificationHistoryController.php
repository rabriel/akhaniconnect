<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Models\VerificationRecord;
use App\Services\Procurement\ProcurementOnboardingService;
use App\Services\Verification\VerificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerificationHistoryController extends Controller
{
    /**
     * Display the procurement user's verification records.
     */
    public function index(Request $request): View
    {
        $records = $request->user()
            ->verificationRecords()
            ->with('attempts')
            ->orderBy('module')
            ->get();

        return view('procurement.verifications.history', compact('records'));
    }

    /**
     * Show a single verification record and attempt history.
     */
    public function show(Request $request, VerificationRecord $verificationRecord): View
    {
        abort_unless($verificationRecord->user_id === $request->user()->id, 403);

        $verificationRecord->load('attempts');

        return view('procurement.verifications.show', compact('verificationRecord'));
    }

    /**
     * Retry a verification using the last stored payload.
     */
    public function retry(
        Request $request,
        VerificationRecord $verificationRecord,
        VerificationService $verificationService,
        ProcurementOnboardingService $procurementOnboardingService
    ): RedirectResponse {
        abort_unless($verificationRecord->user_id === $request->user()->id, 403);

        $verificationService->retry($verificationRecord);
        $procurementOnboardingService->refreshVerificationProgress($request->user());

        return redirect()
            ->route('procurement.verifications.show', $verificationRecord)
            ->with('status', 'Verification re-submitted successfully.');
    }
}
