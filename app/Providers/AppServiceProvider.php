<?php

namespace App\Providers;

use App\Models\User;
use Laravel\Passport\Passport;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Pastikan default logging ke stderr kalau .env belum diset
        config(['logging.default' => env('LOG_CHANNEL', 'stderr')]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Pastikan direktori compiled views ada (pakai VIEW_COMPILED_PATH atau fallback /tmp/views)
        $compiled = config('view.compiled', sys_get_temp_dir() . '/views');
        if (!is_dir($compiled)) {
            @mkdir($compiled, 0777, true);
        }

        // Observers
        User::observe(UserObserver::class);

        // Passport (authorization screen + expiry)
        Passport::authorizationView('oauth.authorize');
        Passport::tokensExpireIn(now()->addDays(15));
        Passport::refreshTokensExpireIn(now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        Password::defaults(function () {
            return Password::min(8)
                ->mixedCase()   // A-Z dan a-z
                ->numbers()     // 0-9
                ->symbols();    // simbol
            // ->uncompromised(); // aktifkan kalau mau cek breach database
        });
    }
}