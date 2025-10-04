<?php

namespace TrodevIT\TroPay;

<<<<<<< HEAD
use Illuminate\Support\ServiceProvider;
=======
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use TrodevIT\TroPay\Helpers\Client;

>>>>>>> 4ac89975b899b3345b38af8d3d9296ce133c53c9

class TroPayServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
<<<<<<< HEAD
        $this->mergeConfigFrom(__DIR__ . '/config/bkash.php', 'bkash');

        $this->app->singleton('bkash', function ($app) {
            return new \TrodevIT\TroPay\Helpers\BkashClient($app['config']);
        });
=======
        $this->mergeConfigFrom(__DIR__.'/config/tropay.php', 'tropay');

        $this->app->bind('tropay', function ($app) {
            return new Client($app->make('request'));
        });

>>>>>>> 4ac89975b899b3345b38af8d3d9296ce133c53c9
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
<<<<<<< HEAD
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'tropay');
=======
        $this->publishes([
            __DIR__.'/config/tropay.php' => config_path('tropay.php'),
        ], 'config');

        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
>>>>>>> 4ac89975b899b3345b38af8d3d9296ce133c53c9
    }
}
