<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Definiowanie bramek (gate) dla różnych ról użytkowników
        Gate::define('isAdmin', function ($user) {
            return $user->position === 'admin';
        });

        Gate::define('isSecretary', function ($user) {
            return $user->position === 'secretary' || $user->position === 'admin';
        });

        Gate::define('isManager', function ($user) {
            return $user->position === 'manager' || $user->position === 'admin';
        });

        Gate::define('isFoodTechnologist', function ($user) {
            return $user->position === 'food_technologist' || $user->position === 'admin';
        });
    }
}
