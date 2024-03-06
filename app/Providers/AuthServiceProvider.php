<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        /**
         * Check role dev.
         */
        Gate::define('dev', function ($user) {
            return $user->roles()->where('name', 'dev')->count() > 0;
        });

        /**
         * Check role moderator.
         */
        Gate::define('moderator', function ($user) {
            return $user->roles()->whereIn('name', ['dev', 'admin', 'moderator'])->count() > 0;
        });
    }
}
