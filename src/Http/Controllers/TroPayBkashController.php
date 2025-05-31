<?php

namespace TrodevIT\TroPay\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use TrodevIT\TroPay\Helpers\Client;
use Illuminate\Support\Facades\DB;
class TroPayBkashController extends Controller
{
    protected $appKey;
    protected $appSecret;
    protected $credential;
//    public function initiate(Client $bkashclient, Request $request)
//    {

//        $tokenData = $bkashclient->getToken();

//        if (isset($tokenData['error']) && $tokenData['error']) {
//            return response()->json($tokenData, 400);
//        }
// //        dd($tokenData);
//        return response()->json($tokenData);
//    }
    public function initiate(Request $request)
    {
        $amount = $request->input('amount', 1); // Default amount 1
        $bkash = new Client($request);

        $paymentResult = $bkash->createPayment($amount);

        if ($paymentResult['status'] && isset($paymentResult['data']['bkashURL'])) {
            dd($paymentResult['data']['bkashURL']);
            return redirect()->away($paymentResult['data']['bkashURL']);
        }

        return response()->json($paymentResult, 500);
    }

    public function callback(Request $request)
    {
        $paymentId = $request->query('paymentID');

        if (!$paymentId) {
            return response()->json(['error' => 'paymentID not provided'], 400);
        }

        $bkash = new Client();
        $executionResult = $bkash->executePayment($paymentId);

        return response()->json($executionResult);
    }

    public function query(Request $request)
    {
        $paymentId = $request->query('paymentID');

        if (!$paymentId) {
            return response()->json(['error' => 'paymentID not provided'], 400);
        }

        $bkash = new Client();
        $result = $bkash->queryPayment($paymentId);

        return response()->json($result);
    }
}
