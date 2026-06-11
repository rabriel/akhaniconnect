<?php

namespace App\Services\Admin;

use App\Models\UserActivity;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AdminAnalyticsService
{
    /**
     * Build admin analytics page data.
     *
     * @return array<string, mixed>
     */
    public function build(): array
    {
        return [
            'activitiesCount' => UserActivity::query()->count(),
            'uniqueIpsCount' => UserActivity::query()->whereNotNull('ip_address')->distinct('ip_address')->count('ip_address'),
            'activeUsersCount' => UserActivity::query()->distinct('user_id')->count('user_id'),
            'loginCount' => UserActivity::query()->where('activity_type', 'login')->count(),
            'recentActivities' => $this->recentActivities(),
            'topBrowsers' => $this->topBreakdown('browser'),
            'topCountries' => $this->topBreakdown('country_name'),
            'topRoutes' => $this->topBreakdown('route_name'),
        ];
    }

    public function paginateActivities(): LengthAwarePaginator
    {
        return UserActivity::query()
            ->with('user.role')
            ->latest('occurred_at')
            ->paginate(15);
    }

    protected function recentActivities(): Collection
    {
        return UserActivity::query()
            ->with('user.role')
            ->latest('occurred_at')
            ->take(8)
            ->get();
    }

    protected function topBreakdown(string $column): Collection
    {
        return UserActivity::query()
            ->selectRaw($column . ', COUNT(*) as aggregate')
            ->whereNotNull($column)
            ->groupBy($column)
            ->orderByDesc('aggregate')
            ->take(5)
            ->get()
            ->map(function ($row) use ($column): array {
                return [
                    'label' => $row->{$column} ?: 'Unknown',
                    'aggregate' => (int) $row->aggregate,
                ];
            });
    }
}
