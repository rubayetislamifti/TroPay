<?php

namespace TrodevIT\TroPay\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use TrodevIT\TroPay\Helpers\BkashClient;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;

class BkashController extends Controller
{
    protected $bkashClient;

    public function pay()
    {
        $bkashClient = Config::class->get('bkash');
        $payment = $bkashClient->createPayment(100, 'INV12345');

        return Redirect::away($payment['bkashURL']);
    }
    public function __construct(BkashClient $bkashClient)
    {
        $this->bkashClient = $bkashClient;
    }

    public function createPayment(Request $request)
    {
        $amount = $request->input('amount');
        $invoice = $request->input('invoice', null);
        $intent = $request->input('intent', 'sale');

        try {
            $payment = $this->bkashClient->createPayment($amount, $invoice, $intent);
            return Response::json($payment);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function executePayment(Request $request)
    {
        $paymentId = $request->input('paymentId');

        try {
            $result = $this->bkashClient->executePayment($paymentId);
            return Response::json($result);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()], 500);
        }
    }

    public function queryPayment(Request $request)
    {
        $paymentId = $request->input('paymentId');

        try {
            $result = $this->bkashClient->queryPayment($paymentId);
            return Response::json($result);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()], 500);
        }
    }
}

