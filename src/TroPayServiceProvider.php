<?php

namespace TrodevIT\TroPay;

use Illuminate\Support\ServiceProvider;
use TrodevIT\TroPay\Helpers\Client;
use TrodevIT\TroPay\Middleware\AppAuthMiddleware;

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

        $this->app->bind('tropay', function () {
            return new Client();
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

        $router = $this->app['router'];
        $router->aliasMiddleware('tropay.auth', AppAuthMiddleware::class);

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }
}
