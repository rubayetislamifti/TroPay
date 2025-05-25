<?php

namespace TrodevIT\TroPay;

use Illuminate\Support\ServiceProvider;

class BKashServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/bkash.php', 'bkash');

        $this->app->singleton('bkash', function ($app) {
            return new \TrodevIT\TroPay\Helpers\BkashClient($app['config']);
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'bkash');
    }
}
