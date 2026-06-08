<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Models\VerificationRecord;

class AdminReportService
{
    /**
     * Build admin reporting data.
     *
     * @return array<string, mixed>
     */
    public function build(): array
    {
        return [
            'roleCounts' => User::query()
                ->selectRaw('roles.name as role_name, COUNT(users.id) as aggregate')
                ->join('roles', 'roles.id', '=', 'users.role_id')
                ->groupBy('roles.name')
                ->pluck('aggregate', 'role_name'),
            'moduleCounts' => VerificationRecord::query()
                ->selectRaw('module, COUNT(id) as aggregate')
                ->groupBy('module')
                ->pluck('aggregate', 'module'),
            'statusCounts' => VerificationRecord::query()
                ->selectRaw('status, COUNT(id) as aggregate')
                ->groupBy('status')
                ->pluck('aggregate', 'status'),
            'recentVerifications' => VerificationRecord::query()
                ->with('user.role')
                ->latest('updated_at')
                ->take(10)
                ->get(),
        ];
    }
}
