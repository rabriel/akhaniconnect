<?php

namespace App\Services\Candidate;

use App\Models\Job;
use App\Models\User;

class CandidateDashboardService
{
    /**
     * Build candidate dashboard data.
     *
     * @return array<string, mixed>
     */
    public function build(User $user): array
    {
        $user->loadMissing(['candidateProfile', 'documents']);

        $applications = $user->applications()
            ->with('job.user.recruitmentProfile')
            ->latest()
            ->take(5)
            ->get();

        $availableJobs = Job::query()
            ->with('user.recruitmentProfile')
            ->where('status', 'published')
            ->latest('published_at')
            ->take(5)
            ->get();

        return [
            'profileComplete' => filled($user->candidateProfile?->job_title)
                && filled($user->candidateProfile?->job_industry)
                && filled($user->candidateProfile?->notice_period)
                && filled($user->candidateProfile?->skills),
            'applicationsCount' => $user->applications()->count(),
            'submittedApplicationsCount' => $user->applications()->where('status', 'submitted')->count(),
            'publishedJobsCount' => Job::query()->where('status', 'published')->count(),
            'documentsCount' => $user->documents->where('category', 'candidate_profile')->count(),
            'recentApplications' => $applications,
            'availableJobs' => $availableJobs,
        ];
    }
}
