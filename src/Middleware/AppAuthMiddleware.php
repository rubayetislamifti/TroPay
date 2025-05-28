<?php

namespace TrodevIT\TroPay\Middleware;

use Closure;

use Illuminate\Support\Facades;
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
        $info = DB::table('payment_infos')::where(function ($query) use ($appKey, $appSecret) {
            $query->where('live_app_key', $appKey)
                ->where('live_app_secret', $appSecret)
                ->orWhere('sandbox_app_key', $appKey)
                ->where('sandbox_app_secret', $appSecret);
        })->first();

        if (!$info) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return $next($request);
    }

}
