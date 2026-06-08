<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $rolePermissions = [
            1 => [
                'dashboard.view',
                'profile.view',
                'profile.update',
                'users.manage',
                'roles.manage',
                'settings.manage',
                'reports.view',
                'clients.manage',
            ],
            2 => [
                'dashboard.view',
                'profile.view',
                'profile.update',
            ],
            3 => [
                'dashboard.view',
                'profile.view',
                'profile.update',
            ],
            4 => [
                'dashboard.view',
                'profile.view',
                'profile.update',
            ],
            5 => [
                'dashboard.view',
                'profile.view',
                'profile.update',
            ],
        ];

        $permissionIds = DB::table('permissions')
            ->pluck('id', 'slug')
            ->all();

        $timestamp = now();
        $rows = [];

        foreach ($rolePermissions as $roleId => $permissionSlugs) {
            foreach ($permissionSlugs as $permissionSlug) {
                if (! isset($permissionIds[$permissionSlug])) {
                    continue;
                }

                $rows[] = [
                    'role_id' => $roleId,
                    'permission_id' => $permissionIds[$permissionSlug],
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ];
            }
        }

        DB::table('permission_role')->upsert(
            $rows,
            ['role_id', 'permission_id'],
            ['updated_at']
        );
    }
}
