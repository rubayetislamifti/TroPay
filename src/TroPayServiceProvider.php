<?php

namespace TrodevIT\TroPay;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use TrodevIT\TroPay\Helpers\Client;


class TroPayServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/tropay.php', 'tropay');

        $this->app->bind('tropay', function ($app) {
            return new Client($app->make('request'));
        });

    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/tropay.php' => config_path('tropay.php'),
        ], 'config');

        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
    }
}
