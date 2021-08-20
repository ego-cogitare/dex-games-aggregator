<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

/**
 * Class MarketsApiServiceProvider
 * @package App\Providers
 */
class AtomicHubApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Components\Api\AtomicHub', function ($app) {
            return new \App\Components\Api\AtomicHub(
                env('ATOMIC_API_ROUTER'),
                env('ATOMIC_API_AUTH')
            );
        });
    }
}
