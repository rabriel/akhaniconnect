<?php

namespace App\Services\Auth;

use App\Models\User;

class LoginRedirectService
{
    /**
     * Resolve the route name that should handle the user's dashboard.
     */
    public function resolveDashboardRouteName(User $user): string
    {
        if ($user->hasRole('candidate') && ! $user->hasVerifiedIdentity()) {
            return 'candidate.identity-verification.show';
        }

        if ($user->hasRole('client') && ! $user->hasVerifiedIdentity()) {
            return 'client.identity-verification.show';
        }

        if ($user->hasRole('recruitment') && ! $user->hasVerifiedIdentity()) {
            return 'recruitment.identity-verification.show';
        }

        if ($user->hasRole('procurement') && ! $user->hasVerifiedIdentity()) {
            return 'procurement.identity-verification.show';
        }

        return match ($user->role?->slug) {
            'superadmin' => 'admin.dashboard',
            'candidate' => 'candidate.dashboard',
            'recruitment' => 'recruitment.dashboard',
            'procurement' => 'procurement.dashboard',
            'client' => 'client.dashboard',
            default => 'profile.edit',
        };
    }
}
