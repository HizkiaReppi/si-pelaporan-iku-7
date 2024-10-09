<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('super-admin', function (User $user) {
            return $user->role === 'super-admin'
                ? Response::allow()
                : Response::deny('You must be an super administrator.');
        });

        Gate::define('admin', function (User $user) {
            return $user->role === 'admin'
                ? Response::allow()
                : Response::deny('You must be an administrator.');
        });
    }
}
