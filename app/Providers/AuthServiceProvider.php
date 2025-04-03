<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        /* Define Gate isAdmin
        Gate::define('isAdmin', function (User $user) {
        return $user->logRole === 'admin';
        });*/

        /* Define Gate isConnected to AuthCheck */
        Gate::define('isConnected', function (User $user ) {
            return Auth::check();
        });
    }
}
