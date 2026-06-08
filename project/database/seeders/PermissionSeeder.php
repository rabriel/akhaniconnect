<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $timestamp = now();

        DB::table('permissions')->upsert([
            [
                'name' => 'View dashboard',
                'slug' => 'dashboard.view',
                'description' => 'Access role dashboard pages.',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'View profile',
                'slug' => 'profile.view',
                'description' => 'View own account profile.',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'Update profile',
                'slug' => 'profile.update',
                'description' => 'Update own account profile.',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'Manage users',
                'slug' => 'users.manage',
                'description' => 'Create, update, and manage platform users.',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'Manage roles',
                'slug' => 'roles.manage',
                'description' => 'Manage system roles and access assignments.',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'Manage settings',
                'slug' => 'settings.manage',
                'description' => 'Update platform-level settings.',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'View reports',
                'slug' => 'reports.view',
                'description' => 'Access reporting pages.',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
            [
                'name' => 'Manage clients',
                'slug' => 'clients.manage',
                'description' => 'Create and manage client accounts.',
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ],
        ], ['slug'], ['name', 'description', 'updated_at']);
    }
}
