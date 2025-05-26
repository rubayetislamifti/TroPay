<?php

use Illuminate\Support\Facades\Route;
use TrodevIT\TroPay\Http\Controllers\BkashController;

Route::get('/payment-type', [BkashController::class, 'index'])->name('tropay.bkash.pay');
