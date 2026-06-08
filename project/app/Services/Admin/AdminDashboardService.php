<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Models\VerificationRecord;

class AdminDashboardService
{
    /**
     * Build superadmin dashboard metrics.
     *
     * @return array<string, mixed>
     */
    public function build(): array
    {
        return [
            'usersCount' => User::query()->count(),
            'clientsCount' => User::query()->whereHas('role', fn ($query) => $query->where('slug', 'client'))->count(),
            'procurementUsersCount' => User::query()->whereHas('role', fn ($query) => $query->where('slug', 'procurement'))->count(),
            'openVerificationsCount' => VerificationRecord::query()->whereIn('status', ['pending', 'failed'])->count(),
            'recentUsers' => User::query()->with('role')->latest()->take(5)->get(),
            'verificationBreakdown' => VerificationRecord::query()
                ->selectRaw('status, COUNT(*) as aggregate')
                ->groupBy('status')
                ->pluck('aggregate', 'status'),
        ];
    }
}
