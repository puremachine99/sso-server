<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Laravel\Passport\Events\AccessTokenCreated;
use App\Listeners\LogPassportLogin;

class EventServiceProvider extends ServiceProvider
{
    // protected $listen = [
    //     AccessTokenCreated::class => [
    //         LogPassportLogin::class,
    //     ],
    // ];

    public function boot(): void
    {
        //
    }
}
