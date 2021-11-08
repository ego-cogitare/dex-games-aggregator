<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

/**
 * Class WaxApiServiceProvider
 * @package App\Providers
 */
class WaxApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Components\Api\WAX', function ($app) {
            return new \App\Components\Api\WAX;
        });
    }
}
