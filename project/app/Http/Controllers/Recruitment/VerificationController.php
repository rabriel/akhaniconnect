<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Verification\StoreSouthAfricanIdVerificationRequest;
use App\Services\Verification\VerificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VerificationController extends Controller
{
    /**
     * Show the recruitment identity verification page.
     */
    public function show(): View
    {
        $user = request()->user()->loadMissing(['verificationRecords.attempts', 'profile']);
        $record = $user->verificationRecords->firstWhere('module', 'sa_identity');

        return view('recruitment.verifications.identity', compact('user', 'record'));
    }

    /**
     * Submit the recruiter SA ID verification.
     */
    public function store(
        StoreSouthAfricanIdVerificationRequest $request,
        VerificationService $verificationService
    ): RedirectResponse {
        $verificationService->verifySouthAfricanId($request->user(), $request->validated()['id_number']);

        return redirect()
            ->route('recruitment.identity-verification.show')
            ->with('status', 'SA ID verification submitted successfully.');
    }
}
