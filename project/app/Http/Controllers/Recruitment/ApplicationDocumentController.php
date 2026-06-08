<?php

namespace App\Http\Controllers\Recruitment;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Document;
use App\Services\Recruitment\CandidateManagementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ApplicationDocumentController extends Controller
{
    /**
     * Download a candidate application document for recruiter review.
     */
    public function show(
        Request $request,
        Application $application,
        Document $document,
        CandidateManagementService $candidateManagementService
    ): StreamedResponse {
        $application = $candidateManagementService->findManagedApplication($request->user(), $application);
        abort_unless($document->application_id === $application->id, 404);

        return Storage::disk('public')->download(
            $document->path,
            $document->original_name
        );
    }

    /**
     * Download a candidate profile document for recruiter review.
     */
    public function showCandidateDocument(
        Request $request,
        Application $application,
        Document $document,
        CandidateManagementService $candidateManagementService
    ): StreamedResponse {
        $application = $candidateManagementService->findManagedApplication($request->user(), $application);

        abort_unless(
            $document->user_id === $application->candidate_user_id
            && $document->category === 'candidate_profile',
            404
        );

        return Storage::disk('public')->download(
            $document->path,
            $document->original_name
        );
    }
}
