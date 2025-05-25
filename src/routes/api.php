<?php

use Illuminate\Support\Facades\Route;

Route::get('/tropay/bkash/pay', [\TrodevIT\TroPay\Http\Controllers\BkashController::class, 'pay'])->name('tropay.bkash.pay');

Route::prefix('bkash')->group(function () {
    Route::post('/create-payment', [\TrodevIT\TroPay\Http\Controllers\BkashController::class, 'createPayment'])
        ->name('bkash.createPayment');

    Route::post('/execute-payment', [\TrodevIT\TroPay\Http\Controllers\BkashController::class, 'executePayment'])
        ->name('bkash.executePayment');

    Route::post('/query-payment', [\TrodevIT\TroPay\Http\Controllers\BkashController::class, 'queryPayment'])
        ->name('bkash.queryPayment');
});
