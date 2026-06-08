<?php

namespace App\Services\Recruitment;

use App\Models\Application;
use App\Models\User;

class RecruitmentDashboardService
{
    /**
     * Build recruitment dashboard data.
     *
     * @return array<string, mixed>
     */
    public function build(User $user): array
    {
        $user->loadMissing('recruitmentProfile');

        $jobsCount = $user->jobs()->count();
        $publishedJobsCount = $user->jobs()->where('status', 'published')->count();
        $applicationsCount = Application::query()
            ->whereHas('job', fn ($query) => $query->where('user_id', $user->id))
            ->count();
        $recentJobs = $user->jobs()
            ->latest()
            ->take(5)
            ->get();
        $recentApplications = Application::query()
            ->with(['job', 'candidate'])
            ->whereHas('job', fn ($query) => $query->where('user_id', $user->id))
            ->latest()
            ->take(5)
            ->get();

        return [
            'profileComplete' => filled($user->recruitmentProfile?->company_name),
            'jobsCount' => $jobsCount,
            'publishedJobsCount' => $publishedJobsCount,
            'applicationsCount' => $applicationsCount,
            'recentJobs' => $recentJobs,
            'recentApplications' => $recentApplications,
        ];
    }
}
