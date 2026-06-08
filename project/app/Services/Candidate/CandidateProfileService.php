<?php

namespace App\Services\Candidate;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class CandidateProfileService
{
    /**
     * Update candidate account and candidate profile details.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data): User {
            $user->update([
                'first_name' => $data['first_name'],
                'surname' => $data['surname'],
                'email' => $data['email'],
                'phone' => $data['phone'],
            ]);

            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'country' => 'ZA',
                    'city' => $data['city'] ?? null,
                    'province' => $data['province'] ?? null,
                ]
            );

            $user->candidateProfile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'job_title' => $data['job_title'] ?? null,
                    'experience_level' => $data['experience_level'] ?? null,
                    'employment_status' => $data['employment_status'] ?? null,
                    'notice_period' => $data['notice_period'] ?? null,
                    'willing_to_relocate' => array_key_exists('willing_to_relocate', $data)
                        ? (bool) $data['willing_to_relocate']
                        : null,
                    'job_industry' => $data['job_industry'] ?? null,
                    'preferred_employment_type' => $data['preferred_employment_type'] ?? null,
                    'salary_expectation' => $data['salary_expectation'] ?? null,
                    'education_level' => $data['education_level'] ?? null,
                    'education' => $data['education'] ?? null,
                    'certifications' => $data['certifications'] ?? null,
                    'experience' => $data['experience'] ?? null,
                    'skills' => $data['skills'] ?? null,
                    'bio' => $data['bio'] ?? null,
                ]
            );

            return $user->fresh(['profile', 'candidateProfile']);
        });
    }
}
