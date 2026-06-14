<?php

namespace App\Services\Procurement;

use App\Models\ProcurementDirector;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProcurementOnboardingService
{
    /**
     * Update procurement personal details.
     *
     * @param  array<string, mixed>  $data
     */
    public function updatePersonalDetails(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data): User {
            $storedIdNumber = $user->profile?->id_number;

            $user->update([
                'first_name' => $data['first_name'],
                'surname' => $data['surname'],
                'email' => $data['email'],
                'phone' => $data['phone'],
            ]);

            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'date_of_birth' => $data['date_of_birth'] ?? null,
                    'gender' => $data['gender'] ?? null,
                    'id_number' => $storedIdNumber,
                    'passport_number' => $data['passport_number'] ?? null,
                    'address_line_1' => $data['address_line_1'] ?? null,
                    'address_line_2' => $data['address_line_2'] ?? null,
                    'suburb' => $data['suburb'] ?? null,
                    'city' => $data['city'] ?? null,
                    'province' => $data['province'] ?? null,
                    'postal_code' => $data['postal_code'] ?? null,
                    'country' => 'ZA',
                    'identity_verified' => $user->profile?->identity_verified ?? false,
                    'identity_verified_at' => $user->profile?->identity_verified_at,
                    'profile_completed' => $this->isPersonalSectionComplete($data, $storedIdNumber),
                ]
            );

            $this->refreshVerificationProgress($user);

            return $user->fresh(['profile', 'procurementProfile']);
        });
    }

    /**
     * Update procurement enterprise details.
     *
     * @param  array<string, mixed>  $data
     */
    public function updateEnterpriseDetails(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data): User {
            $profile = $user->procurementProfile()->firstOrCreate(['user_id' => $user->id]);
            $registrationNumber = $data['registration_number'];
            $registrationChanged = $profile->registration_number !== $registrationNumber;

            $profile->update([
                'registration_number' => $registrationNumber,
                'company_name' => $registrationChanged ? null : $profile->company_name,
                'vat_number' => $registrationChanged ? null : $profile->vat_number,
                'company_phone' => $registrationChanged ? null : $profile->company_phone,
                'enterprise_status' => $registrationChanged ? null : $profile->enterprise_status,
                'enterprise_type' => $registrationChanged ? null : $profile->enterprise_type,
                'enterprise_address' => $registrationChanged ? null : $profile->enterprise_address,
                'enterprise_data' => $registrationChanged ? null : $profile->enterprise_data,
                'enterprise_synced_at' => $registrationChanged ? null : $profile->enterprise_synced_at,
            ]);

            if ($registrationChanged) {
                $enterpriseRecord = $user->verificationRecords()
                    ->where('module', 'enterprise')
                    ->where('verifiable_type', $profile->getMorphClass())
                    ->where('verifiable_id', $profile->id)
                    ->first();

                if ($enterpriseRecord !== null) {
                    $enterpriseRecord->update([
                        'status' => 'pending',
                        'provider_reference' => null,
                        'summary' => null,
                        'last_error' => null,
                        'last_verified_at' => null,
                    ]);
                }
            }

            $this->refreshVerificationProgress($user);

            return $user->fresh(['profile', 'procurementProfile']);
        });
    }

    /**
     * Add a procurement director.
     *
     * @param  array<string, mixed>  $data
     */
    public function addDirector(User $user, array $data): ProcurementDirector
    {
        return DB::transaction(function () use ($user, $data): ProcurementDirector {
            $profile = $user->procurementProfile()->firstOrCreate(
                ['user_id' => $user->id]
            );

            $director = $profile->directors()->firstOrCreate(
                ['id_number' => $data['id_number']],
                [
                    'full_name' => 'Pending verification',
                    'status' => 'saved',
                ]
            );

            $director->update([
                'status' => 'saved',
                'provider_reference' => null,
                'director_status' => null,
                'verification_summary' => null,
                'director_data' => null,
                'verified_at' => null,
            ]);

            $verificationRecord = $user->verificationRecords()
                ->where('module', 'enterprise_director')
                ->where('verifiable_type', $director->getMorphClass())
                ->where('verifiable_id', $director->id)
                ->first();

            if ($verificationRecord !== null) {
                $verificationRecord->update([
                    'status' => 'pending',
                    'provider_reference' => null,
                    'summary' => null,
                    'last_error' => null,
                    'last_verified_at' => null,
                ]);
            }

            $this->refreshVerificationProgress($user);

            return $director;
        });
    }

    /**
     * Build procurement dashboard step data.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getDashboardSteps(User $user): array
    {
        $user->loadMissing(['profile', 'procurementProfile.directors', 'documents', 'verificationRecords']);

        $profile = $user->profile;
        $procurementProfile = $user->procurementProfile;

        return [
            [
                'title' => 'SA ID Verification',
                'status' => $this->hasVerifiedModule($user, 'sa_identity') ? 'verified' : 'pending',
                'description' => $this->hasVerifiedModule($user, 'sa_identity')
                    ? 'Your South African ID has been verified.'
                    : 'Verify your South African ID to unlock the procurement dashboard.',
                'route' => route('procurement.identity-verification.show'),
            ],
            [
                'title' => 'Personal Details',
                'status' => $profile?->profile_completed ? 'verified' : 'pending',
                'description' => $profile?->profile_completed
                    ? 'Your procurement profile details are complete.'
                    : 'Complete your personal and contact details.',
                'route' => route('procurement.profile.edit'),
            ],
            [
                'title' => 'Enterprise Details',
                'status' => $this->hasVerifiedEnterprise($user) ? 'verified' : ($this->isEnterpriseComplete($procurementProfile) ? 'in_progress' : 'pending'),
                'description' => $this->hasVerifiedEnterprise($user)
                    ? 'Enterprise registration details have been verified with CIPC.'
                    : ($this->isEnterpriseComplete($procurementProfile)
                        ? 'Enterprise details are saved and ready for CIPC verification.'
                        : 'Add the company registration number and verify the enterprise details.'),
                'route' => route('procurement.enterprise.edit'),
            ],
            [
                'title' => 'Enterprise Directors',
                'status' => $this->hasVerifiedDirectors($procurementProfile) ? 'verified' : ($this->hasDirectors($procurementProfile) ? 'in_progress' : 'pending'),
                'description' => $this->hasVerifiedDirectors($procurementProfile)
                    ? 'Enterprise directors have been captured and verified.'
                    : ($this->hasDirectors($procurementProfile)
                        ? 'Director records are saved and ready for verification.'
                        : 'Add the directors linked to the enterprise.'),
                'route' => route('procurement.directors.index'),
            ],
            [
                'title' => 'Driver Licence',
                'status' => $this->hasVerifiedModule($user, 'driver_licence') ? 'verified' : 'pending',
                'description' => $this->hasVerifiedModule($user, 'driver_licence')
                    ? 'Your driver licence has been verified through the API.'
                    : 'Upload front and back licence images to verify your driver licence.',
                'route' => route('procurement.verifications.driver-licence'),
                'exclude_from_progress' => true,
            ],
            [
                'title' => 'Documents Upload',
                'status' => $this->hasSupportingDocuments($user) ? 'verified' : 'pending',
                'description' => $this->hasSupportingDocuments($user)
                    ? 'Supporting documents are available for procurement and client review.'
                    : 'Upload supporting documents such as certificates, tax clearance, and related files.',
                'route' => route('procurement.documents.index'),
                'exclude_from_progress' => true,
            ],
        ];
    }

    /**
     * Refresh verification progress for the procurement profile.
     */
    public function refreshVerificationProgress(User $user): void
    {
        $user->loadMissing(['profile', 'procurementProfile.directors', 'verificationRecords']);

        $completedSections = collect([
            $this->hasVerifiedModule($user, 'sa_identity'),
            (bool) $user->profile?->profile_completed,
            $this->hasVerifiedEnterprise($user),
            $this->hasVerifiedDirectors($user->procurementProfile),
        ])->filter()->count();

        $progress = (int) round(($completedSections / 4) * 100);

        $user->procurementProfile()->updateOrCreate(
            ['user_id' => $user->id],
            ['verification_progress' => $progress]
        );
    }

    /**
     * Determine if the profile section is complete.
     *
     * @param  array<string, mixed>  $data
     */
    protected function isPersonalSectionComplete(array $data, ?string $storedIdNumber = null): bool
    {
        return collect([
            $data['first_name'] ?? null,
            $data['surname'] ?? null,
            $data['email'] ?? null,
            $data['phone'] ?? null,
            $storedIdNumber,
        ])->every(fn ($value) => filled($value));
    }

    /**
     * Determine if the enterprise section is complete.
     */
    protected function isEnterpriseComplete($procurementProfile): bool
    {
        if ($procurementProfile === null) {
            return false;
        }

        return collect([
            $procurementProfile->registration_number,
        ])->every(fn ($value) => filled($value));
    }

    /**
     * Determine if directors have been added.
     */
    protected function hasDirectors($procurementProfile): bool
    {
        return $procurementProfile !== null
            && $procurementProfile->directors->isNotEmpty();
    }

    /**
     * Determine if the enterprise has a successful verification record.
     */
    protected function hasVerifiedEnterprise(User $user): bool
    {
        return $user->verificationRecords
            ->where('module', 'enterprise')
            ->where('status', 'verified')
            ->isNotEmpty();
    }

    /**
     * Determine if all saved directors have been verified.
     */
    protected function hasVerifiedDirectors($procurementProfile): bool
    {
        return $procurementProfile !== null
            && $procurementProfile->directors->isNotEmpty()
            && $procurementProfile->directors->every(fn ($director) => $director->status === 'verified');
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
     * Determine if supporting procurement documents have been uploaded.
     */
    protected function hasSupportingDocuments(User $user): bool
    {
        return $user->documents
            ->where('category', 'procurement_profile')
            ->isNotEmpty();
    }
}
