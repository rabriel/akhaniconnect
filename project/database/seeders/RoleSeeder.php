<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $timestamp = now();

        DB::table('roles')->upsert([
            [
                'id' => 1,
                'name' => 'Superadmin',
                'slug' => 'superadmin',
                'description' => 'Platform owner with full administrative access.',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'id' => 2,
                'name' => 'Candidate',
                'slug' => 'candidate',
                'description' => 'Candidate account for job applications and profile management.',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'id' => 3,
                'name' => 'Recruitment',
                'slug' => 'recruitment',
                'description' => 'Recruitment account for managing candidates and recruitment workflows.',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'id' => 4,
                'name' => 'Procurement',
                'slug' => 'procurement',
                'description' => 'Procurement account for verification and enterprise workflows.',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'id' => 5,
                'name' => 'Client',
                'slug' => 'client',
                'description' => 'Client account with controlled access to procurement records.',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
        ], ['id'], ['name', 'slug', 'description', 'updated_at']);
    }
}
