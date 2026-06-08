<?php

namespace App\Services\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ClientManagementService
{
    public function __construct(
        protected \App\Services\Auth\WelcomeEmailService $welcomeEmailService
    ) {
    }

    /**
     * Create a client account and client profile from the admin workflow.
     *
     * @param  array<string, mixed>  $data
     */
    public function create(array $data): User
    {
        $user = DB::transaction(function () use ($data): User {
            $role = Role::query()
                ->where('slug', 'client')
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

            $user->clientProfile()->create([
                'company_name' => $data['company_name'],
                'contact_person_name' => $data['contact_person_name'],
                'company_phone' => $data['company_phone'] ?? null,
                'access_scope' => $data['access_scope'] ?? null,
            ]);

            return $user->load(['role', 'profile', 'clientProfile']);
        });

        $this->welcomeEmailService->send($user);

        return $user;
    }
}
