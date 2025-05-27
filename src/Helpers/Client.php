<?php

namespace TrodevIT\TroPay\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class Client
{
    protected $token;
    protected $credential;

    public function __construct()
    {
        $this->credential = DB::table('payment_infos')->where('provider','bkash')->first();

        if ($this->credential){
            $this->token = $this->getToken();
        }
    }

    public function getToken(){
        $url = Config::get('tropay.base_url') . '/tokenized/checkout/token/grant';

        $headers = [
            'username'=> $this->credential->username,
            'password' => $this->credential->password,
            'Accept' => 'application/json',
        ];

        $body = [
            'app_key'=> $this->credential->app_key,
            'app_secret' => $this->credential->app_secret,
        ];

        $response = Http::withHeaders($headers)->withBody(json_encode($body), 'application/json')->post($url);

        if ($response->successful()) {
            $this->token = $response->json('id_token');

            return true;
        }


        return [
            'error' => true,
            'status' => $response->status(),
            'body' => $response->body(),
        ];

    }

    public function createPayment($amount)
    {
        if (!$this->token) {
            return [
                'status' => false,
                'message' => 'Token not found'
            ];
        }

        $url = config('bkash.base_url') . '/tokenized/checkout/create';

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => $this->token,
            'X-App-Key' => $this->credential->app_key
        ];

        $body = [
            'mode' => '0011',
            'payerReference' => "01615257555",
            'callbackURL' => route('callbackURL'),
            'amount' => $amount,
            'currency' => 'BDT',
            'intent' => 'sale',
            'merchantInvoiceNumber'=> 'INV-' . time()
        ];

//        dd($body);

        try {
            $response = Http::withHeaders($headers)
                ->withBody(json_encode($body), 'application/json')
                ->post($url);

            if ($response->successful()) {
                return [
                    'status' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'status' => false,
                'message' => 'bKash API error',
                'code' => $response->status(),
                'error' => $response->json(),
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Exception: ' . $e->getMessage(),
            ];
        }
    }

    public function executePayment($paymentID){
        $url = config('bkash.base_url') . '/tokenized/checkout/execute';

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => $this->token,
            'X-App-Key' => $this->credential->app_key
        ];

        $body = [
            'paymentID'=>$paymentID,
        ];

//        dd($body);
        try {
            $response = Http::withHeaders($headers)
                ->withBody(json_encode($body), 'application/json')
                ->post($url);

            if ($response->successful()) {
                return [
                    'status' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'status' => false,
                'message' => 'bKash API error',
                'code' => $response->status(),
                'error' => $response->json(),
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Exception: ' . $e->getMessage(),
            ];
        }
    }

    public function queryPayment($paymentID)
    {
        $url = config('bkash.base_url') . '/tokenized/checkout/payment/status';

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => $this->token,
            'X-App-Key' => $this->credential->app_key
        ];

        $body = [
            'paymentID'=>$paymentID,
        ];

//        dd($body);
        try {
            $response = Http::withHeaders($headers)
                ->withBody(json_encode($body), 'application/json')
                ->post($url);

            if ($response->successful()) {
                return [
                    'status' => true,
                    'data' => $response->json(),
                ];
            }

            return [
                'status' => false,
                'message' => 'bKash API error',
                'code' => $response->status(),
                'error' => $response->json(),
            ];
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Exception: ' . $e->getMessage(),
            ];
        }
    }
}
