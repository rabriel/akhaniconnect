<?php

namespace App\Services\Recruitment;

use App\Models\Application;
use App\Models\User;
use App\Notifications\RecruitmentCandidateMessageNotification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class CandidateManagementService
{
    /**
     * Build a recruiter candidate pipeline listing.
     *
     * @param  array<string, mixed>  $filters
     */
    public function paginate(User $recruiter, array $filters): LengthAwarePaginator
    {
        $query = Application::query()
            ->with(['job', 'candidate.profile', 'candidate.candidateProfile', 'candidate.documents'])
            ->withCount('documents')
            ->whereHas('job', fn (Builder $builder) => $builder->where('user_id', $recruiter->id));

        $search = trim((string) ($filters['search'] ?? ''));
        if ($search !== '') {
            $query->where(function (Builder $builder) use ($search): void {
                $builder
                    ->whereHas('candidate', function (Builder $candidateQuery) use ($search): void {
                        $candidateQuery
                            ->where('first_name', 'like', '%' . $search . '%')
                            ->orWhere('surname', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%')
                            ->orWhereHas('candidateProfile', function (Builder $profileQuery) use ($search): void {
                                $profileQuery
                                    ->where('job_title', 'like', '%' . $search . '%')
                                    ->orWhere('experience_level', 'like', '%' . $search . '%');
                            });
                    })
                    ->orWhereHas('job', fn (Builder $jobQuery) => $jobQuery->where('title', 'like', '%' . $search . '%'));
            });
        }

        if (filled($filters['status'] ?? null)) {
            $query->where('status', (string) $filters['status']);
        }

        if (filled($filters['job_id'] ?? null)) {
            $query->where('job_id', (int) $filters['job_id']);
        }

        if (filled($filters['province'] ?? null)) {
            $query->whereHas('candidate.profile', function (Builder $builder) use ($filters): void {
                $builder->where('province', (string) $filters['province']);
            });
        }

        return $query
            ->latest()
            ->paginate(10)
            ->withQueryString();
    }

    /**
     * Ensure an application belongs to the recruiter.
     */
    public function findManagedApplication(User $recruiter, Application $application): Application
    {
        abort_unless($application->job?->user_id === $recruiter->id, 404);

        return $application->load(['job', 'candidate.profile', 'candidate.candidateProfile', 'candidate.documents', 'documents']);
    }

    /**
     * Update recruiter review data for an application.
     *
     * @param  array<string, mixed>  $data
     */
    public function updateApplication(Application $application, array $data): Application
    {
        $application->update([
            'status' => $data['status'],
            'reviewer_notes' => $data['reviewer_notes'] ?? null,
            'reviewed_at' => now(),
        ]);

        return $application->fresh(['job', 'candidate.candidateProfile']);
    }

    /**
     * Send a recruiter message to the candidate.
     *
     * @param  array<string, mixed>  $data
     */
    public function notifyCandidate(User $recruiter, Application $application, array $data): void
    {
        $application->candidate?->notify(new RecruitmentCandidateMessageNotification(
            $recruiter,
            (string) $data['subject'],
            (string) $data['message'],
        ));
    }
}
