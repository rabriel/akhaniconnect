<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperadminSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $timestamp = now();

        DB::table('users')->updateOrInsert(
            ['email' => 'connect@gabrielo.co.za'],
            [
                'role_id' => 1,
                'first_name' => 'Gabriel',
                'surname' => 'Developer',
                'phone' => '0105000000',
                'phone_verified_at' => $timestamp,
                'email_verified_at' => $timestamp,
                'status' => 'active',
                'password' => Hash::make('Thisisdeveloperaccount@1'),
                'updated_at' => $timestamp,
                'created_at' => $timestamp,
            ]
        );

        $user = DB::table('users')
            ->where('email', 'connect@gabrielo.co.za')
            ->first(['id']);

        if ($user === null) {
            return;
        }

        DB::table('profiles')->updateOrInsert(
            ['user_id' => $user->id],
            [
                'country' => 'ZA',
                'identity_verified' => true,
                'identity_verified_at' => $timestamp,
                'profile_completed' => true,
                'updated_at' => $timestamp,
                'created_at' => $timestamp,
            ]
        );
    }
}
