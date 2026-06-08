<?php

namespace App\Services\Recruitment;

use App\Models\Job;
use App\Models\User;

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
            'published_at' => $data['status'] === 'published' ? now() : null,
        ]);
    }
}
