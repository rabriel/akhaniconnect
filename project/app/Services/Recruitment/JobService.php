<?php

namespace App\Services\Recruitment;

use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;

class JobService
{
    /**
     * Create a recruiter-owned job post.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(User $user, array $data): Job
    {
        return $user->jobs()->create([
            'title' => $data['title'],
            'location' => $data['location'] ?? null,
            'province' => $data['province'] ?? null,
            'employment_type' => $data['employment_type'] ?? null,
            'description' => $data['description'],
            'status' => $data['status'],
            'published_at' => $this->resolvePublishedAt($data),
        ]);
    }

    /**
     * Update a recruiter-owned job post.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(Job $job, array $data): Job
    {
        $job->update([
            'title' => $data['title'],
            'location' => $data['location'] ?? null,
            'province' => $data['province'] ?? null,
            'employment_type' => $data['employment_type'] ?? null,
            'description' => $data['description'],
            'status' => $data['status'],
            'published_at' => $this->resolvePublishedAt($data),
        ]);

        return $job->refresh();
    }

    /**
     * Delete a recruiter-owned job post.
     */
    public function delete(Job $job): void
    {
        $job->delete();
    }

    /**
     * Resolve the published at value from recruiter input.
     *
     * @param  array<string, mixed>  $data
     */
    private function resolvePublishedAt(array $data): ?Carbon
    {
        if (($data['status'] ?? 'draft') !== 'published' || empty($data['published_at'])) {
            return null;
        }

        return Carbon::parse((string) $data['published_at'])->startOfDay();
    }
}
