<?php

namespace App\Services\Client;

use App\Models\User;

class ClientDashboardService
{
    /**
     * Build client dashboard data.
     *
     * @return array<string, int>
     */
    public function build(): array
    {
        $procurementUsers = User::query()
            ->whereHas('role', fn ($query) => $query->where('slug', 'procurement'));

        return [
            'procurementUsersCount' => (clone $procurementUsers)->count(),
            'verifiedUsersCount' => (clone $procurementUsers)
                ->whereHas('procurementProfile', fn ($query) => $query->where('verification_progress', 100))
                ->count(),
            'inProgressUsersCount' => (clone $procurementUsers)
                ->whereHas('procurementProfile', fn ($query) => $query->where('verification_progress', '>', 0)->where('verification_progress', '<', 100))
                ->count(),
            'pendingUsersCount' => (clone $procurementUsers)
                ->whereHas('procurementProfile', fn ($query) => $query->where('verification_progress', 0))
                ->orWhereDoesntHave('procurementProfile')
                ->count(),
        ];
    }
}
