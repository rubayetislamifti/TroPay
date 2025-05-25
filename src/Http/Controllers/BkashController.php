<?php

namespace TrodevIT\TroPay\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use TrodevIT\TroPay\Helpers\BkashClient;
use Illuminate\Support\Facades\Response;

class BkashController extends Controller
{
    protected $bkashClient;

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

