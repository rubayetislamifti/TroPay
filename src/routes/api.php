<?php

use Illuminate\Routing\Route;
use TrodevIT\TroPay\Http\Controllers\TroPayBkashController;

Route::middleware(['tropay.auth'])->group(function () {
    Route::post('/tropay/bkash/payment', [TroPayBkashController::class, 'initiate'])->name('bkash.payment');
    Route::get('/tropay/bkash/callback', [TroPayBkashController::class, 'callback'])->name('bkash.callback');
    Route::get('/tropay/bkash/query', [TroPayBkashController::class, 'query'])->name('bkash.query');
});
