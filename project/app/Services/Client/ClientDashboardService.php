<?php

namespace App\Services\Client;

use App\Models\User;
use Carbon\Carbon;

class ClientDashboardService
{
    /**
     * Build client dashboard data.
     *
     * @return array<string, mixed>
     */
    public function build(): array
    {
        $procurementUsersQuery = User::query()
            ->whereHas('role', fn ($query) => $query->where('slug', 'procurement'));

        $procurementUsers = (clone $procurementUsersQuery)
            ->with(['procurementProfile.directors', 'verificationRecords', 'documents', 'profile'])
            ->get();

        $verifiedUsersCount = (clone $procurementUsersQuery)
            ->whereHas('procurementProfile', fn ($query) => $query->where('verification_progress', 100))
            ->count();

        $inProgressUsersCount = (clone $procurementUsersQuery)
            ->whereHas('procurementProfile', fn ($query) => $query->where('verification_progress', '>', 0)->where('verification_progress', '<', 100))
            ->count();

        $pendingUsersCount = (clone $procurementUsersQuery)
            ->where(function ($query): void {
                $query
                    ->whereHas('procurementProfile', fn ($profileQuery) => $profileQuery->where('verification_progress', 0))
                    ->orWhereDoesntHave('procurementProfile');
            })
            ->count();

        $moduleKeys = [
            'sa_identity' => 'SA ID Verification',
            'enterprise' => 'Enterprise Details',
            'enterprise_director' => 'Enterprise Directors',
            'driver_licence' => 'Driver Licence',
        ];

        $moduleBreakdown = collect($moduleKeys)->map(function (string $label, string $module) use ($procurementUsers): array {
            $verifiedCount = $procurementUsers->filter(fn (User $user) => $user->verificationRecords->where('module', $module)->where('status', 'verified')->isNotEmpty())->count();
            $failedCount = $procurementUsers->filter(fn (User $user) => $user->verificationRecords->where('module', $module)->where('status', 'failed')->isNotEmpty())->count();
            $pendingCount = max($procurementUsers->count() - $verifiedCount - $failedCount, 0);

            return [
                'module' => $module,
                'label' => $label,
                'verified' => $verifiedCount,
                'failed' => $failedCount,
                'pending' => $pendingCount,
            ];
        })->values();

        $progressBands = [
            ['label' => 'Pending', 'count' => $pendingUsersCount, 'color' => '#64748b'],
            ['label' => 'In Progress', 'count' => $inProgressUsersCount, 'color' => '#f59e0b'],
            ['label' => 'Verified', 'count' => $verifiedUsersCount, 'color' => '#18b76a'],
        ];

        $moduleVerifiedSeries = $moduleBreakdown->map(fn (array $item) => $item['verified'])->values();
        $moduleLabels = $moduleBreakdown->map(fn (array $item) => $item['label'])->values();

        $months = collect(range(5, 0))
            ->sort()
            ->map(fn (int $offset) => now()->startOfMonth()->subMonths($offset))
            ->values();

        $activitySeries = $months->map(function (Carbon $month) use ($procurementUsers): int {
            return $procurementUsers->sum(function (User $user) use ($month): int {
                return $user->verificationRecords
                    ->filter(fn ($record) => $record->last_verified_at && $record->last_verified_at->copy()->startOfMonth()->equalTo($month))
                    ->count();
            });
        })->values();

        $recentlyVerifiedUsers = $procurementUsers
            ->filter(fn (User $user) => ($user->procurementProfile?->verification_progress ?? 0) > 0)
            ->sortByDesc(fn (User $user) => $this->latestVerificationDate($user)?->timestamp ?? 0)
            ->take(5)
            ->map(function (User $user): array {
                $verifiedModules = $user->verificationRecords->where('status', 'verified')->count();

                return [
                    'name' => $user->full_name,
                    'company' => $user->procurementProfile?->company_name ?: 'Company not verified yet',
                    'progress' => $user->procurementProfile?->verification_progress ?? 0,
                    'verified_modules' => $verifiedModules,
                    'directors_verified' => ($user->procurementProfile?->directors ?? collect())->where('status', 'verified')->count(),
                    'documents_uploaded' => $user->documents->count(),
                    'last_verified_at' => $this->latestVerificationDate($user),
                ];
            })
            ->values();

        return [
            'procurementUsersCount' => $procurementUsers->count(),
            'verifiedUsersCount' => $verifiedUsersCount,
            'inProgressUsersCount' => $inProgressUsersCount,
            'pendingUsersCount' => $pendingUsersCount,
            'documentsCount' => $procurementUsers->sum(fn (User $user) => $user->documents->count()),
            'verifiedDirectorsCount' => $procurementUsers->sum(fn (User $user) => ($user->procurementProfile?->directors ?? collect())->where('status', 'verified')->count()),
            'verificationRecordsCount' => $procurementUsers->sum(fn (User $user) => $user->verificationRecords->count()),
            'moduleBreakdown' => $moduleBreakdown,
            'recentlyVerifiedUsers' => $recentlyVerifiedUsers,
            'charts' => [
                'progressDistribution' => [
                    'labels' => collect($progressBands)->pluck('label')->values(),
                    'series' => collect($progressBands)->pluck('count')->values(),
                    'colors' => collect($progressBands)->pluck('color')->values(),
                ],
                'moduleCoverage' => [
                    'labels' => $moduleLabels,
                    'series' => $moduleVerifiedSeries,
                    'color' => '#e76505',
                ],
                'verificationActivity' => [
                    'labels' => $months->map(fn (Carbon $month) => $month->format('M Y'))->values(),
                    'series' => $activitySeries,
                    'color' => '#202124',
                ],
            ],
        ];
    }

    protected function latestVerificationDate(User $user): ?Carbon
    {
        return $user->verificationRecords
            ->pluck('last_verified_at')
            ->filter()
            ->sortDesc()
            ->first();
    }
}
