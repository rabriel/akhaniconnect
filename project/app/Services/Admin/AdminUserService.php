<?php

namespace App\Services\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminUserService
{
    public function __construct(
        protected \App\Services\Auth\WelcomeEmailService $welcomeEmailService
    ) {
    }

    /**
     * Create a user from the superadmin workflow.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): User
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
                'status' => $data['status'],
            ]);

            $user->profile()->create([
                'country' => 'ZA',
            ]);

            match ($role->slug) {
                'candidate' => $user->candidateProfile()->create(),
                'recruitment' => $user->recruitmentProfile()->create(),
                'procurement' => $user->procurementProfile()->create(),
                'client' => $user->clientProfile()->create(),
                default => null,
            };

            return $user->load(['role', 'profile']);
        });

        $this->welcomeEmailService->send($user);

        return $user;
    }

    /**
     * Update a managed user from the superadmin workflow.
     *
     * @param  array<string, mixed>  $data
     */
    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data): User {
            $role = Role::query()
                ->where('slug', $data['role'])
                ->firstOrFail();

            $user->update([
                'role_id' => $role->id,
                'first_name' => $data['first_name'],
                'surname' => $data['surname'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'status' => $data['status'],
            ]);

            return $user->fresh(['role', 'profile']);
        });
    }
}
