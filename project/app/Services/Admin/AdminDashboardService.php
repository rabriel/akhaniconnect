<?php

namespace App\Services\Admin;

use App\Models\User;
use App\Models\UserActivity;
use App\Models\VerificationRecord;
use Carbon\Carbon;

class AdminDashboardService
{
    /**
     * Build superadmin dashboard metrics.
     *
     * @return array<string, mixed>
     */
    public function build(): array
    {
        $roleDistribution = User::query()
            ->selectRaw('roles.name as role_name, COUNT(users.id) as aggregate')
            ->join('roles', 'roles.id', '=', 'users.role_id')
            ->groupBy('roles.name')
            ->orderBy('roles.id')
            ->get();

        $verificationBreakdown = VerificationRecord::query()
            ->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $months = collect(range(5, 0))
            ->sort()
            ->map(fn (int $offset) => now()->startOfMonth()->subMonths($offset))
            ->values();

        $registrationActivity = $months->map(function (Carbon $month): int {
            return User::query()
                ->whereBetween('created_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])
                ->count();
        })->values();

        $loginActivity = $months->map(function (Carbon $month): int {
            return UserActivity::query()
                ->where('activity_type', 'login')
                ->whereBetween('occurred_at', [$month->copy()->startOfMonth(), $month->copy()->endOfMonth()])
                ->count();
        })->values();

        return [
            'usersCount' => User::query()->count(),
            'clientsCount' => User::query()->whereHas('role', fn ($query) => $query->where('slug', 'client'))->count(),
            'procurementUsersCount' => User::query()->whereHas('role', fn ($query) => $query->where('slug', 'procurement'))->count(),
            'openVerificationsCount' => VerificationRecord::query()->whereIn('status', ['pending', 'failed'])->count(),
            'recentUsers' => User::query()->with('role')->latest()->take(5)->get(),
            'verificationBreakdown' => $verificationBreakdown,
            'charts' => [
                'roleDistribution' => [
                    'labels' => $roleDistribution->pluck('role_name')->values(),
                    'series' => $roleDistribution->pluck('aggregate')->map(fn ($count) => (int) $count)->values(),
                    'colors' => ['#202124', '#18b76a', '#e76505', '#2563eb', '#a855f7'],
                ],
                'verificationStatuses' => [
                    'labels' => $verificationBreakdown->keys()->map(fn ($status) => str($status)->replace('_', ' ')->title())->values(),
                    'series' => $verificationBreakdown->values()->map(fn ($count) => (int) $count)->values(),
                    'colors' => ['#18b76a', '#f59e0b', '#ef4444', '#64748b'],
                ],
                'platformActivity' => [
                    'labels' => $months->map(fn (Carbon $month) => $month->format('M Y'))->values(),
                    'registration_series' => $registrationActivity,
                    'login_series' => $loginActivity,
                    'registration_color' => '#e76505',
                    'login_color' => '#202124',
                ],
            ],
        ];
    }
}
