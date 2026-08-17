<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Seed the application's default role accounts.
     */
    public function run(): void
    {
        $timestamp = now();

        $users = [
            [
                'role_id' => 1,
                'email' => 'admin@akhaniconnect.co.za',
                'password' => 'TestingAccount@2026',
                'first_name' => 'Aisha',
                'surname' => 'Nkosi',
                'phone' => '0820000001',
                'gender' => 'Female',
                'profile' => [
                    'city' => 'Johannesburg',
                    'province' => 'Gauteng',
                    'identity_verified' => true,
                    'profile_completed' => true,
                ],
            ],
            [
                'role_id' => 2,
                'email' => 'candidate@akhaniconnect.co.za',
                'password' => 'TestingAccount@2026',
                'first_name' => 'Themba',
                'surname' => 'Mokoena',
                'phone' => '0820000002',
                'gender' => 'Male',
                'profile' => [
                    'city' => 'Pretoria',
                    'province' => 'Gauteng',
                    'identity_verified' => true,
                    'profile_completed' => true,
                ],
                'candidate_profile' => [
                    'job_title' => 'Procurement Administrator',
                    'experience_level' => 'Mid-level',
                    'employment_status' => 'Available',
                    'bio' => 'Seeded candidate account for Akhani Connect testing.',
                ],
                'verification' => [
                    'module' => 'sa_identity',
                    'status' => 'verified',
                    'provider_reference' => 'seeded-candidate-sa-id',
                ],
            ],
            [
                'role_id' => 3,
                'email' => 'recruitment@akhaniconnect.co.za',
                'password' => 'TestingAccount@2026',
                'first_name' => 'Refilwe',
                'surname' => 'Naidoo',
                'phone' => '0820000003',
                'gender' => 'Female',
                'profile' => [
                    'city' => 'Cape Town',
                    'province' => 'Western Cape',
                    'identity_verified' => true,
                    'profile_completed' => true,
                ],
                'recruitment_profile' => [
                    'company_name' => 'Akhani Talent',
                    'registration_number' => '2026/000001/07',
                    'website' => 'https://akhaniconnect.co.za',
                    'company_phone' => '0215550101',
                    'contact_person_name' => 'Refilwe Naidoo',
                ],
            ],
            [
                'role_id' => 4,
                'email' => 'procurement@akhaniconnect.co.za',
                'password' => 'TestingAccount@2026',
                'first_name' => 'Lerato',
                'surname' => 'Mabena',
                'phone' => '0820000004',
                'gender' => 'Female',
                'profile' => [
                    'city' => 'Durban',
                    'province' => 'KwaZulu-Natal',
                    'identity_verified' => true,
                    'profile_completed' => true,
                ],
                'procurement_profile' => [
                    'company_name' => 'Akhani Procurement Services',
                    'registration_number' => '201408196207',
                    'vat_number' => '4123456789',
                    'company_phone' => '0315550101',
                    'verification_progress' => 100,
                ],
                'verification' => [
                    'module' => 'sa_identity',
                    'status' => 'verified',
                    'provider_reference' => 'seeded-procurement-sa-id',
                ],
            ],
            [
                'role_id' => 5,
                'email' => 'client@akhaniconnect.co.za',
                'password' => 'TestingAccount@2026',
                'first_name' => 'Nandi',
                'surname' => 'Dlamini',
                'phone' => '0820000005',
                'gender' => 'Female',
                'profile' => [
                    'city' => 'Bloemfontein',
                    'province' => 'Free State',
                    'identity_verified' => true,
                    'profile_completed' => true,
                ],
                'client_profile' => [
                    'company_name' => 'Akhani Client Group',
                    'contact_person_name' => 'Nandi Dlamini',
                    'company_phone' => '0515550101',
                    'access_scope' => 'All procurement records',
                ],
            ],
        ];

        foreach ($users as $account) {
            $this->seedUserAccount($account, $timestamp);
        }
    }

    /**
     * Seed a single default user account and related profile records.
     */
    protected function seedUserAccount(array $account, $timestamp): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => $account['email']],
            [
                'role_id' => $account['role_id'],
                'first_name' => $account['first_name'],
                'surname' => $account['surname'],
                'phone' => $account['phone'],
                'phone_verified_at' => $timestamp,
                'email_verified_at' => $timestamp,
                'status' => 'active',
                'password' => Hash::make($account['password']),
                'updated_at' => $timestamp,
                'created_at' => $timestamp,
            ]
        );

        $user = DB::table('users')
            ->where('email', $account['email'])
            ->first(['id']);

        if ($user === null) {
            return;
        }

        DB::table('profiles')->updateOrInsert(
            ['user_id' => $user->id],
            [
                'gender' => $account['gender'],
                'city' => $account['profile']['city'],
                'province' => $account['profile']['province'],
                'country' => 'ZA',
                'identity_verified' => $account['profile']['identity_verified'],
                'identity_verified_at' => $account['profile']['identity_verified'] ? $timestamp : null,
                'profile_completed' => $account['profile']['profile_completed'],
                'updated_at' => $timestamp,
                'created_at' => $timestamp,
            ]
        );

        if (isset($account['candidate_profile'])) {
            DB::table('candidate_profiles')->updateOrInsert(
                ['user_id' => $user->id],
                array_merge($account['candidate_profile'], [
                    'updated_at' => $timestamp,
                    'created_at' => $timestamp,
                ])
            );
        }

        if (isset($account['recruitment_profile'])) {
            DB::table('recruitment_profiles')->updateOrInsert(
                ['user_id' => $user->id],
                array_merge($account['recruitment_profile'], [
                    'updated_at' => $timestamp,
                    'created_at' => $timestamp,
                ])
            );
        }

        if (isset($account['procurement_profile'])) {
            DB::table('procurement_profiles')->updateOrInsert(
                ['user_id' => $user->id],
                array_merge($account['procurement_profile'], [
                    'updated_at' => $timestamp,
                    'created_at' => $timestamp,
                ])
            );
        }

        if (isset($account['client_profile'])) {
            DB::table('client_profiles')->updateOrInsert(
                ['user_id' => $user->id],
                array_merge($account['client_profile'], [
                    'updated_at' => $timestamp,
                    'created_at' => $timestamp,
                ])
            );
        }

        if (isset($account['verification'])) {
            DB::table('verification_records')->updateOrInsert(
                [
                    'user_id' => $user->id,
                    'module' => $account['verification']['module'],
                ],
                [
                    'provider' => 'verifynow',
                    'status' => $account['verification']['status'],
                    'provider_reference' => $account['verification']['provider_reference'],
                    'summary' => json_encode(['seeded' => true]),
                    'last_verified_at' => $timestamp,
                    'updated_at' => $timestamp,
                    'created_at' => $timestamp,
                ]
            );
        }
    }
}
