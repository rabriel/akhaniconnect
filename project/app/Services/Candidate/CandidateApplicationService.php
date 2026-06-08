<?php

namespace App\Services\Candidate;

use App\Models\Job;
use App\Models\User;
use App\Services\Document\DocumentUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CandidateApplicationService
{
    public function __construct(
        protected DocumentUploadService $documentUploadService
    ) {
    }

    /**
     * Submit a job application for a candidate.
     *
     * @param  array<string, mixed>  $data
     */
    public function apply(User $user, Job $job, array $data): void
    {
        if ($job->status !== 'published') {
            throw ValidationException::withMessages([
                'job' => 'This job is not open for applications.',
            ]);
        }

        $alreadyApplied = $user->applications()
            ->where('job_id', $job->id)
            ->exists();

        if ($alreadyApplied) {
            throw ValidationException::withMessages([
                'job' => 'You have already applied for this position.',
            ]);
        }

        DB::transaction(function () use ($user, $job, $data): void {
            $application = $user->applications()->create([
                'job_id' => $job->id,
                'status' => 'submitted',
                'cover_letter' => $data['cover_letter'] ?? null,
                'applied_at' => now(),
            ]);

            /** @var UploadedFile|null $cvDocument */
            $cvDocument = $data['cv_document'] ?? null;
            if ($cvDocument instanceof UploadedFile) {
                $this->documentUploadService->upload(
                    $user,
                    $cvDocument,
                    'job_application',
                    'cv',
                    $application
                );
            }

            foreach (($data['supporting_documents'] ?? []) as $supportingDocument) {
                if (! $supportingDocument instanceof UploadedFile) {
                    continue;
                }

                $this->documentUploadService->upload(
                    $user,
                    $supportingDocument,
                    'job_application',
                    'supporting_document',
                    $application
                );
            }
        });
    }
}
