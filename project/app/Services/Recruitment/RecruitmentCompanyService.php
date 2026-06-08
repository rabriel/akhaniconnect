<?php

namespace App\Services\Recruitment;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class RecruitmentCompanyService
{
    /**
     * Update recruitment company and account details.
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
                ['country' => 'ZA']
            );

            $user->recruitmentProfile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'company_name' => $data['company_name'],
                    'registration_number' => $data['registration_number'] ?? null,
                    'website' => $data['website'] ?? null,
                    'company_phone' => $data['company_phone'] ?? null,
                    'contact_person_name' => $data['contact_person_name'] ?? null,
                ]
            );

            return $user->fresh(['profile', 'recruitmentProfile']);
        });
    }
}
