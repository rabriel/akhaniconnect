<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Verification\StoreDriverLicenceVerificationRequest;
use App\Http\Requests\Verification\StoreSouthAfricanIdVerificationRequest;
use App\Services\Document\DocumentUploadService;
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

    /**
     * Show the candidate driver licence verification page.
     */
    public function driverLicence(): View
    {
        $user = request()->user()->loadMissing(['verificationRecords.attempts', 'documents']);
        $record = $user->verificationRecords->firstWhere('module', 'driver_licence');
        $documents = $user->documents->where('category', 'driver_licence');

        return view('candidate.verifications.driver-licence', compact('record', 'documents'));
    }

    /**
     * Store a candidate driver licence verification attempt.
     */
    public function storeDriverLicence(
        StoreDriverLicenceVerificationRequest $request,
        DocumentUploadService $documentUploadService,
        VerificationService $verificationService
    ): RedirectResponse {
        $frontDocument = $documentUploadService->upload(
            $request->user(),
            $request->file('front_image'),
            'driver_licence',
            'driver_licence_front'
        );

        $backDocument = null;
        if ($request->hasFile('back_image')) {
            $backDocument = $documentUploadService->upload(
                $request->user(),
                $request->file('back_image'),
                'driver_licence',
                'driver_licence_back'
            );
        }

        $verificationService->verifyDriverLicence(
            $request->user(),
            [
                'front' => $frontDocument->path,
                'back' => $backDocument?->path,
            ],
            $request->file('front_image'),
            $request->file('back_image')
        );

        return redirect()
            ->route('candidate.verifications.driver-licence')
            ->with('status', 'Driver licence verification submitted successfully.');
    }
}
