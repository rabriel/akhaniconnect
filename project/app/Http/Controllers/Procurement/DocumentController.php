<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Procurement\StoreProcurementDocumentsRequest;
use App\Http\Requests\Procurement\StoreProofOfAddressRequest;
use App\Models\Document;
use App\Services\Document\DocumentUploadService;
use App\Services\Procurement\ProcurementOnboardingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    /**
     * Show the procurement document workspace.
     */
    public function index(Request $request): View
    {
        $documents = $request->user()
            ->documents()
            ->where('category', 'procurement_profile')
            ->latest()
            ->get();

        return view('procurement.documents.index', compact('documents'));
    }

    /**
     * Store procurement supporting documents.
     */
    public function store(
        StoreProcurementDocumentsRequest $request,
        DocumentUploadService $documentUploadService
    ): RedirectResponse {
        foreach ($request->validated('documents') as $documentData) {
            $documentUploadService->upload(
                $request->user(),
                $documentData['file'],
                'procurement_profile',
                'supporting_document',
                null,
                (string) $documentData['name']
            );
        }

        return redirect()
            ->route('procurement.documents.index')
            ->with('status', 'Procurement documents uploaded successfully.');
    }

    /**
     * Download a procurement supporting document.
     */
    public function show(Request $request, Document $document): StreamedResponse
    {
        abort_unless(
            $document->user_id === $request->user()->id && $document->category === 'procurement_profile',
            404
        );

        return Storage::disk('public')->download($document->path, $document->download_name);
    }

    /**
     * Show the proof of address upload page.
     */
    public function proofOfAddress(Request $request): View
    {
        $documents = $request->user()
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
