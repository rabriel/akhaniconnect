<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Procurement\StoreBankAccountVerificationRequest;
use App\Http\Requests\Verification\StoreDriverLicenceVerificationRequest;
use App\Http\Requests\Verification\StoreSouthAfricanIdVerificationRequest;
use App\Services\Document\DocumentUploadService;
use App\Services\Procurement\ProcurementOnboardingService;
use App\Services\Verification\VerificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VerificationController extends Controller
{
    /**
     * Show the procurement identity verification page.
     */
    public function identity(): View
    {
        $user = request()->user()->loadMissing(['verificationRecords.attempts', 'profile']);
        $record = $user->verificationRecords->firstWhere('module', 'sa_identity');

        return view('procurement.verifications.identity', compact('user', 'record'));
    }

    /**
     * Store a procurement identity verification attempt.
     */
    public function storeIdentity(
        StoreSouthAfricanIdVerificationRequest $request,
        VerificationService $verificationService,
        ProcurementOnboardingService $procurementOnboardingService
    ): RedirectResponse {
        $verificationService->verifySouthAfricanId($request->user(), $request->validated()['id_number']);
        $procurementOnboardingService->refreshVerificationProgress($request->user());

        return redirect()
            ->route('procurement.identity-verification.show')
            ->with('status', 'SA ID verification submitted successfully.');
    }

    /**
     * Show the driver licence verification page.
     */
    public function driverLicence(): View
    {
        $user = request()->user()->loadMissing(['verificationRecords.attempts', 'documents']);
        $record = $user->verificationRecords->firstWhere('module', 'driver_licence');
        $documents = $user->documents->where('category', 'driver_licence');

        return view('procurement.verifications.driver-licence', compact('record', 'documents'));
    }

    /**
     * Store a driver licence verification attempt.
     */
    public function storeDriverLicence(
        StoreDriverLicenceVerificationRequest $request,
        DocumentUploadService $documentUploadService,
        VerificationService $verificationService,
        ProcurementOnboardingService $procurementOnboardingService
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

        $procurementOnboardingService->refreshVerificationProgress($request->user());

        return redirect()
            ->route('procurement.verifications.driver-licence')
            ->with('status', 'Driver licence verification submitted successfully.');
    }

    /**
     * Show the bank account verification page.
     */
    public function bankAccount(): View
    {
        $user = request()->user()->loadMissing('verificationRecords.attempts');
        $record = $user->verificationRecords->firstWhere('module', 'bank_account');

        return view('procurement.verifications.bank-account', compact('record'));
    }

    /**
     * Store a bank account verification attempt.
     */
    public function storeBankAccount(
        StoreBankAccountVerificationRequest $request,
        VerificationService $verificationService,
        ProcurementOnboardingService $procurementOnboardingService
    ): RedirectResponse {
        $verificationService->verifyBankAccount($request->user(), $request->validated());
        $procurementOnboardingService->refreshVerificationProgress($request->user());

        return redirect()
            ->route('procurement.verifications.bank-account')
            ->with('status', 'Bank account verification submitted successfully.');
    }
}
