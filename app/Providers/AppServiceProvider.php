<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Passport::enablePasswordGrant();

        // Passport 13.x: Maintain compatibility with integer client IDs
        Passport::$clientUuids = false;

        // Passport 13.x: Validate key permissions on supported OS
        if (! windows_os()) {
            chmod(Passport::keyPath('oauth-public.key'), 0660);
            chmod(Passport::keyPath('oauth-private.key'), 0600);
        }
    }
}
