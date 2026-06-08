<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Http\Requests\Candidate\StoreCandidateDocumentRequest;
use App\Models\Document;
use App\Services\Document\DocumentUploadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    /**
     * Display the candidate document workspace.
     */
    public function index(Request $request): View
    {
        $documents = $request->user()
            ->documents()
            ->where('category', 'candidate_profile')
            ->latest()
            ->get();

        $documentTypes = config('south_africa.candidate_document_types', []);

        return view('candidate.documents.index', compact('documents', 'documentTypes'));
    }

    /**
     * Store a candidate-owned profile document.
     */
    public function store(
        StoreCandidateDocumentRequest $request,
        DocumentUploadService $documentUploadService
    ): JsonResponse {
        $document = $documentUploadService->upload(
            $request->user(),
            $request->file('file'),
            'candidate_profile',
            (string) $request->validated('type')
        );

        return response()->json([
            'status' => 'Candidate document uploaded successfully.',
            'document_id' => $document->id,
        ]);
    }

    /**
     * Download a candidate-owned profile document.
     */
    public function show(Request $request, Document $document): StreamedResponse
    {
        abort_unless(
            $document->user_id === $request->user()->id && $document->category === 'candidate_profile',
            404
        );

        return Storage::disk('public')->download($document->path, $document->original_name);
    }
}
