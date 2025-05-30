<?php

use Illuminate\Support\Facades\Route;
use TrodevIT\TroPay\Http\Controllers\TroPayBkashController;
use TrodevIT\TroPay\Middleware\AppAuthMiddleware;

Route::middleware(AppAuthMiddleware::class)->group(function () {
//    Route::get('/tropay/bkash/token', [TroPayBkashController::class, 'getToken'])->name('tropay.token');
    Route::post('/tropay/bkash/payment', [TroPayBkashController::class, 'initiate'])->name('tropay.payment');
    Route::get('/tropay/bkash/callback', [TroPayBkashController::class, 'callback'])->name('tropay.callback');
    Route::get('/tropay/bkash/query', [TroPayBkashController::class, 'query'])->name('tropay.query');
});
