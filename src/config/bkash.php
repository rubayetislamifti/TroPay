<?php

return [
    'base_url' => env('BKASH_BASE_URL', 'https://127.0.0.1.sandbox.bka.sh'),
    'sandbox' => env('BKASH_SANDBOX'),
    'app_key' => env('BKASH_APP_KEY'),
    'app_secret' => env('BKASH_APP_SECRET'),
    'username' => env('BKASH_USERNAME'),
    'password' => env('BKASH_PASSWORD'),
    'callback_url' => env('BKASH_CALLBACK_URL'),
];
