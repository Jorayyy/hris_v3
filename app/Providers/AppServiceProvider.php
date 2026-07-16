<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Super Admin Access Gate
        Gate::define('is-super-admin', function ($user) {
            return $user->role === 'super_admin';
        });

        // Combined Admin & Management Access Gate
        Gate::define('is-admin', function ($user) {
            return in_array($user->role, ['super_admin', 'admin', 'hr']);
        });

        // Specific HR Access Gate
        Gate::define('is-hr', function ($user) {
            return in_array($user->role, ['super_admin', 'admin', 'hr']);
        });

        // Accounting Access Gate
        Gate::define('is-accounting', function ($user) {
            return in_array($user->role, ['super_admin', 'accounting']);
        });
    }
}
