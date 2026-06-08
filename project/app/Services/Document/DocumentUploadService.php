<?php

namespace App\Services\Document;

use App\Models\Application;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class DocumentUploadService
{
    /**
     * Store a document for the given user.
     */
    public function upload(
        User $user,
        UploadedFile $file,
        string $category,
        string $type,
        ?Application $application = null
    ): Document
    {
        return DB::transaction(function () use ($user, $file, $category, $type, $application): Document {
            $path = $file->store("documents/{$category}", 'public');

            return Document::query()->create([
                'user_id' => $user->id,
                'application_id' => $application?->id,
                'category' => $category,
                'type' => $type,
                'original_name' => $file->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $file->getClientMimeType() ?: $file->getMimeType() ?: 'application/octet-stream',
                'size' => $file->getSize(),
                'status' => 'uploaded',
                'uploaded_at' => now(),
            ]);
        });
    }
}
