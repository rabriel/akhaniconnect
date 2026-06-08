<?php

namespace App\Providers;

use App\Models\Profile;
use App\Models\User;
use App\Policies\ProfilePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Profile::class => ProfilePolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function (User $user) {
            return $user->isSuperadmin() ? true : null;
        });

        $permissionSlugs = [
            'dashboard.view',
            'profile.view',
            'profile.update',
            'users.manage',
            'roles.manage',
            'settings.manage',
            'reports.view',
            'clients.manage',
        ];

        foreach ($permissionSlugs as $permissionSlug) {
            Gate::define($permissionSlug, fn (User $user): bool => $user->hasPermissionTo($permissionSlug));
        }
    }
}
