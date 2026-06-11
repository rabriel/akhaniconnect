<?php

namespace App\Services\Admin;

use App\Models\User;

class AdminUserInsightService
{
    /**
     * Build a procurement detail payload for superadmin review.
     *
     * @return array<string, mixed>
     */
    public function procurementDetail(User $procurementUser): array
    {
        $procurementUser->loadMissing([
            'profile',
            'procurementProfile.directors.verificationRecords',
            'verificationRecords.attempts',
            'documents',
        ]);

        return [
            'user' => $procurementUser,
            'verifiedModules' => $procurementUser->verificationRecords->where('status', 'verified')->pluck('module')->values(),
            'enterpriseRecord' => $procurementUser->verificationRecords->where('module', 'enterprise')->first(),
            'verifiedDirectors' => ($procurementUser->procurementProfile?->directors ?? collect())
                ->where('status', 'verified')
                ->values(),
            'procurementDocuments' => $procurementUser->documents
                ->where('category', 'procurement_profile')
                ->sortByDesc('uploaded_at')
                ->values(),
        ];
    }

    /**
     * Build a candidate detail payload for superadmin review.
     *
     * @return array<string, mixed>
     */
    public function candidateDetail(User $candidateUser): array
    {
        $candidateUser->loadMissing([
            'profile',
            'candidateProfile',
            'documents',
            'applications.job',
        ]);

        $applications = $candidateUser->applications()
            ->with('job')
            ->withCount('documents')
            ->latest('applied_at')
            ->get();

        return [
            'user' => $candidateUser,
            'candidateDocuments' => $candidateUser->documents
                ->where('category', 'candidate_profile')
                ->sortByDesc('uploaded_at')
                ->values(),
            'applicationDocuments' => $candidateUser->documents
                ->where('category', 'job_application')
                ->sortByDesc('uploaded_at')
                ->values(),
            'applications' => $applications,
        ];
    }
}
