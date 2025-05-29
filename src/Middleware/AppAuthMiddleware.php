<?php

namespace TrodevIT\TroPay\Middleware;

use Closure;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
class AppAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $appKey = $request->header('App-Key');
        $appSecret = $request->header('App-Secret');

        if (!$appKey || !$appSecret) {
            return response()->json(['message' => 'App credentials missing'], 401);
        }



        return $next($request);
    }


}
