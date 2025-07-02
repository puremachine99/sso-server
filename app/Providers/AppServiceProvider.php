<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

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
        // Gunakan view Blade standar untuk halaman authorize
        Passport::authorizationView('oauth.authorize');

        // Atur masa berlaku token jika diperlukan
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        // (Opsional) Scope kustom, bisa kamu aktifkan nanti
        // Passport::tokensCan([
        //     'view-profile' => 'View your profile',
        //     'edit-settings' => 'Edit your account settings',
        // ]);
    }
}
