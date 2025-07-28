<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
    ];

    public function boot(): void
    {
        Gate::define('manage-patients', function (User $user) {
            return in_array($user->tipo, ['Admin', 'Secretaria']);
        });
        Gate::define('manage-users', function (User $user) {
            return $user->tipo === 'Admin';
        });
        Gate::define('is-professional', function (User $user) {
            return $user->tipo === 'Profissional';
        });
    }
}