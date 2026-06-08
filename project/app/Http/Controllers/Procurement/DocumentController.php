<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Procurement\StoreProofOfAddressRequest;
use App\Services\Document\DocumentUploadService;
use App\Services\Procurement\ProcurementOnboardingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DocumentController extends Controller
{
    /**
     * Show the proof of address upload page.
     */
    public function proofOfAddress(): View
    {
        $documents = request()->user()
            ->documents()
            ->where('category', 'proof_of_address')
            ->latest()
            ->get();

        return view('procurement.documents.proof-of-address', compact('documents'));
    }

    /**
     * Store a proof of address document.
     */
    public function storeProofOfAddress(
        StoreProofOfAddressRequest $request,
        DocumentUploadService $documentUploadService,
        ProcurementOnboardingService $procurementOnboardingService
    ): RedirectResponse {
        $documentUploadService->upload(
            $request->user(),
            $request->file('document'),
            'proof_of_address',
            'proof_of_address'
        );

        $procurementOnboardingService->refreshVerificationProgress($request->user());

        return redirect()
            ->route('procurement.documents.proof-of-address')
            ->with('status', 'Proof of address uploaded successfully.');
    }
}
