<?php

namespace TrodevIT\TroPay;

use Illuminate\Support\ServiceProvider;
use TrodevIT\TroPay\Helpers\Client;
use TrodevIT\TroPay\Middleware\AppAuthMiddleware;
use Illuminate\Support\Facades\Route;
use TrodevIT\TroPay\Http\Controllers\TroPayBkashController;
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
        $router->aliasMiddleware('tropay', AppAuthMiddleware::class);

        Route::middleware(['api', 'tropay'])->group(function () {
            Route::post('/tropay/bkash/payment', [TroPayBkashController::class, 'initiate'])->name('tropay.payment');
            Route::get('/tropay/bkash/callback', [TroPayBkashController::class, 'callback'])->name('tropay.callback');
            Route::get('/tropay/bkash/query', [TroPayBkashController::class, 'query'])->name('tropay.query');
        });

    }
}
