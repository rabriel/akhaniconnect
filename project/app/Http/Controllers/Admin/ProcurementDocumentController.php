<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProcurementDocumentController extends Controller
{
    /**
     * Download a procurement user's supporting document for superadmin review.
     */
    public function show(User $procurementUser, Document $document): StreamedResponse
    {
        abort_unless($procurementUser->hasRole('procurement'), 404);
        abort_unless(
            $document->user_id === $procurementUser->id && $document->category === 'procurement_profile',
            404
        );

        return Storage::disk('public')->download($document->path, $document->download_name);
    }
}
