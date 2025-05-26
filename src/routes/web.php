<?php

use Illuminate\Support\Facades\Route;
use TrodevIT\TroPay\Http\Controllers\BkashController;

Route::get('/payment-type', [BkashController::class, 'index'])->name('tropay.bkash.pay');
Route::prefix('tropay')->group(function () {
    Route::get('/pay', [BkashController::class, 'pay'])->name('tropay.pay');
    Route::post('/create-payment', [BkashController::class, 'createPayment'])->name('tropay.createPayment');
    Route::post('/execute-payment', [BkashController::class, 'executePayment'])->name('tropay.executePayment');
    Route::post('/query-payment', [BkashController::class, 'queryPayment'])->name('tropay.queryPayment');
});
