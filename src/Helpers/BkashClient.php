<?php

namespace TrodevIT\TroPay\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Config\Repository as Config;

class BkashClient
{
    protected $config;
    protected $token;

    public function __construct(Config $config)
    {
        $this->config = $config->get('bkash');
        $this->token = null;
    }

    public function getToken()
    {
        if ($this->token) {
            return $this->token;
        }

        $response = Http::withBasicAuth(
            $this->config['username'],
            $this->config['password']
        )->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post(rtrim($this->config['base_url'], '/'.'/checkout/token/grant',
                [
                'app_key' => $this->config['app_key'],
                'app_secret' => $this->config['app_secret'],
            ]);

        if ($response->successful()) {
            $data = $response->json();
            $this->token = $data['id_token'];
            return $this->token;
        }

        throw new \Exception('Failed to retrieve token: ' . $response->body());
    }

    public function createPayment($amount, $invoice = null, $intent = 'sale')
    {
        $token = $this->getToken();

        $payload = [
            'amount' => $amount,
            'intent' => $intent,
            'currency' => 'BDT',
            'callbackURL' => $this->config['callback_url'],
        ];

        if ($invoice) {
            $payload['merchantInvoiceNumber'] = $invoice;
        }

        $response = Http::withHeaders([
            'Authorization' => $token,
            'X-APP-Key' => $this->config['app_key'],
            'Content-Type' => 'application/json',
        ])->post($this->config['base_url'] . '/tokenized/checkout/create', $payload);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Failed to create payment: ' . $response->body());
    }
    public function executePayment($paymentId)
    {
        $token = $this->getToken();

        $response = Http::withHeaders([
            'Authorization' => $token,
            'X-APP-Key' => $this->config['app_key'],
            'Content-Type' => 'application/json',
        ])->post($this->config['base_url'] . '/tokenized/checkout/execute', [
            'paymentID' => $paymentId,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Failed to execute payment: ' . $response->body());
    }

    public function queryPayment($paymentID)
    {
        $this->getToken();
        return Http::withHeaders([
            'Authorization' => $this->token,
            'X-APP-Key' => $this->config['app_key'],
        ])->get($this->config['base_url'] . '/tokenized/checkout/agreement/status' . $paymentID)->json();
    }
}
