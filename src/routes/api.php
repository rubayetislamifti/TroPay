<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use TrodevIT\TroPay\Http\Controllers\BkashController;

//Route::get('/payment-type', [BkashController::class, 'index'])->name('tropay.bkash.pay');
//Route::prefix('tropay')->group(function () {
//    Route::get('/pay', [BkashController::class, 'pay'])->name('tropay.pay');
//    Route::post('/create-payment', [BkashController::class, 'createPayment'])->name('tropay.createPayment');
//    Route::post('/execute-payment', [BkashController::class, 'executePayment'])->name('tropay.executePayment');
//    Route::post('/query-payment', [BkashController::class, 'queryPayment'])->name('tropay.queryPayment');
//});
=======
use TrodevIT\TroPay\Http\Controllers\TroPayBkashController;
use TrodevIT\TroPay\Middleware\AppAuthMiddleware;


//    Route::get('/tropay/bkash/token', [TroPayBkashController::class, 'getToken'])->name('tropay.token');
    Route::post('/tropay/bkash/payment', [TroPayBkashController::class, 'initiate'])->name('tropay.payment');
    Route::get('/tropay/bkash/callback', [TroPayBkashController::class, 'callback'])->name('tropay.callback');
    Route::get('/tropay/bkash/query', [TroPayBkashController::class, 'query'])->name('tropay.query');
>>>>>>> 4ac89975b899b3345b38af8d3d9296ce133c53c9

