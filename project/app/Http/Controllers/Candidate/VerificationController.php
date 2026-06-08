<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Verification\StoreSouthAfricanIdVerificationRequest;
use App\Services\Verification\VerificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VerificationController extends Controller
{
    /**
     * Show the candidate identity verification page.
     */
    public function show(): View
    {
        $user = request()->user()->loadMissing(['verificationRecords.attempts', 'profile']);
        $record = $user->verificationRecords->firstWhere('module', 'sa_identity');

        return view('candidate.verifications.identity', compact('user', 'record'));
    }

    /**
     * Submit the candidate SA ID verification.
     */
    public function store(
        StoreSouthAfricanIdVerificationRequest $request,
        VerificationService $verificationService
    ): RedirectResponse {
        $verificationService->verifySouthAfricanId($request->user(), $request->validated()['id_number']);

        return redirect()
            ->route('candidate.identity-verification.show')
            ->with('status', 'SA ID verification submitted successfully.');
    }
}
