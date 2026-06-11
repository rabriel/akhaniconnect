<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CandidateDocumentController extends Controller
{
    /**
     * Download a candidate-owned document for superadmin review.
     */
    public function show(User $candidateUser, Document $document): StreamedResponse
    {
        abort_unless($candidateUser->hasRole('candidate'), 404);
        abort_unless(
            $document->user_id === $candidateUser->id
            && in_array($document->category, ['candidate_profile', 'job_application'], true),
            404
        );

        return Storage::disk('public')->download($document->path, $document->download_name);
    }
}
