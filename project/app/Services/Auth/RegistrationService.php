<?php

namespace App\Services\Auth;

use App\Models\CandidateProfile;
use App\Models\ClientProfile;
use App\Models\ProcurementProfile;
use App\Models\Profile;
use App\Models\RecruitmentProfile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RegistrationService
{
    public function __construct(
        protected WelcomeEmailService $welcomeEmailService
    ) {
    }

    /**
     * Register a new user and create the related profile records.
     *
     * @param  array<string, mixed>  $data
     */
    public function register(array $data): User
    {
        $user = DB::transaction(function () use ($data): User {
            $role = Role::query()
                ->where('slug', $data['role'])
                ->firstOrFail();

            /** @var User $user */
            $user = User::query()->create([
                'role_id' => $role->id,
                'first_name' => $data['first_name'],
                'surname' => $data['surname'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => $data['password'],
                'status' => 'active',
            ]);

            $user->profile()->create([
                'country' => 'ZA',
            ]);

            $this->createRoleSpecificProfile($user, $role->slug);

            return $user->load(['role', 'profile']);
        });

        $this->welcomeEmailService->send($user);

        return $user;
    }

    /**
     * Create the appropriate role-specific profile shell.
     */
    protected function createRoleSpecificProfile(User $user, string $roleSlug): void
    {
        match ($roleSlug) {
            'candidate' => CandidateProfile::query()->create(['user_id' => $user->id]),
            'recruitment' => RecruitmentProfile::query()->create(['user_id' => $user->id]),
            'procurement' => ProcurementProfile::query()->create(['user_id' => $user->id]),
            'client' => ClientProfile::query()->create(['user_id' => $user->id]),
            default => null,
        };
    }
}
