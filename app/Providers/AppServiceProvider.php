<?php

namespace App\Providers;

use App\Models\User;
use Laravel\Passport\Passport;
use App\Observers\UserObserver;
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

        // $url->forceScheme('https');

        User::observe(UserObserver::class);
        // Existing Passport setup – do not remove
        Passport::authorizationView('oauth.authorize');
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
