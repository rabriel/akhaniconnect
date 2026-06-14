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
        $user->loadMissing(['candidateProfile', 'documents', 'profile', 'verificationRecords']);

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

        $profileComplete = $this->isProfileComplete($user);
        $hasUploadedDocuments = $this->hasSupportingDocuments($user);
        $hasDriversLicence = $this->hasDriversLicence($user);
        $steps = [
            [
                'title' => 'SA ID Verification',
                'status' => $this->hasVerifiedModule($user, 'sa_identity') ? 'verified' : 'pending',
                'description' => $this->hasVerifiedModule($user, 'sa_identity')
                    ? 'Your South African ID has been verified.'
                    : 'Verify your South African ID to unlock the candidate workspace.',
                'route' => route('candidate.identity-verification.show'),
            ],
            [
                'title' => 'Personal Details',
                'status' => $profileComplete ? 'verified' : 'pending',
                'description' => $profileComplete
                    ? 'Your candidate details are complete.'
                    : 'Complete your profile so recruiters can review your background properly.',
                'route' => route('candidate.profile.edit'),
            ],
            [
                'title' => 'Documents Upload',
                'status' => $hasUploadedDocuments ? 'verified' : 'pending',
                'description' => $hasUploadedDocuments
                    ? 'Candidate documents are available for recruiter review.'
                    : 'Upload your CV, qualifications, and supporting documents.',
                'route' => route('candidate.documents.index'),
            ],
            [
                'title' => 'Drivers Licence',
                'status' => $this->hasVerifiedModule($user, 'driver_licence') ? 'verified' : 'pending',
                'description' => $this->hasVerifiedModule($user, 'driver_licence')
                    ? 'Your driver\'s licence has been verified through the API.'
                    : ($hasDriversLicence
                        ? 'Driver\'s licence images are uploaded and ready for verification.'
                        : 'Upload front and optional back images to verify your driver\'s licence through the API.'),
                'route' => route('candidate.verifications.driver-licence'),
                'exclude_from_progress' => true,
            ],
        ];

        $completedSections = collect($steps)
            ->reject(fn (array $step) => (bool) ($step['exclude_from_progress'] ?? false))
            ->where('status', 'verified')
            ->count();
        $progress = (int) round(($completedSections / 3) * 100);

        return [
            'user' => $user,
            'profileComplete' => $profileComplete,
            'applicationsCount' => $user->applications()->count(),
            'submittedApplicationsCount' => $user->applications()->where('status', 'submitted')->count(),
            'publishedJobsCount' => Job::query()->where('status', 'published')->count(),
            'documentsCount' => $user->documents->where('category', 'candidate_profile')->count(),
            'recentApplications' => $applications,
            'availableJobs' => $availableJobs,
            'steps' => $steps,
            'progress' => $progress,
        ];
    }

    /**
     * Determine if the candidate profile is complete enough for recruiter review.
     */
    protected function isProfileComplete(User $user): bool
    {
        return filled($user->candidateProfile?->job_title)
            && filled($user->candidateProfile?->job_industry)
            && filled($user->candidateProfile?->notice_period)
            && filled($user->candidateProfile?->skills);
    }

    /**
     * Determine if a verification module has a successful record.
     */
    protected function hasVerifiedModule(User $user, string $module): bool
    {
        return $user->verificationRecords
            ->where('module', $module)
            ->where('status', 'verified')
            ->isNotEmpty();
    }

    /**
     * Determine if supporting candidate documents have been uploaded.
     */
    protected function hasSupportingDocuments(User $user): bool
    {
        return $user->documents
            ->where('category', 'candidate_profile')
            ->isNotEmpty();
    }

    /**
     * Determine if a driver's licence document has been uploaded.
     */
    protected function hasDriversLicence(User $user): bool
    {
        return $user->documents
            ->where('category', 'driver_licence')
            ->isNotEmpty();
    }
}
