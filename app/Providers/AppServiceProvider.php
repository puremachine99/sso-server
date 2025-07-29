<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

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
    public function boot(UrlGenerator $url): void
    {
        // ngilangin mixedcontent di filament kwkwkw
        // if (env('APP_ENV') !== 'local') {
        //     $url->forceScheme('https');
        // }

        // Existing Passport setup – do not remove
        Passport::authorizationView('oauth.authorize');
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
