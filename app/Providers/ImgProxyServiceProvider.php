<?php

namespace App\Providers;

use App\Services\ImgProxyService;
use Illuminate\Support\ServiceProvider;

class ImgProxyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(ImgProxyService::class, function ($app) {
            return new ImgProxyService();
        });
    }

    public function boot()
    {
        //
    }
}
