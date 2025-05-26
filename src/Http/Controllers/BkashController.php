<?php

namespace TrodevIT\TroPay\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use TrodevIT\TroPay\Helpers\BkashClient;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;

class BkashController extends Controller
{
    protected $bkashClient;

    // ✅ Constructor injection works fine
    public function __construct(BkashClient $bkashClient)
    {
        $this->bkashClient = $bkashClient;
    }

    public static function index()
    {
        return View::make('tropay::paymentType');
    }
    // ✅ Pay and redirect to bKash URL
    public function pay()
    {
        try {
            $payment = $this->bkashClient->createPayment(100, 'INV12345');
            return Redirect::away($payment['bkashURL']);
        } catch (\Exception $e) {
            return Response::json(['error' => $e->getMessage()], 500);
        }
    }

    // ✅ API to create payment with params
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

    // ✅ API to execute payment
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

    // ✅ API to query payment status
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
