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

        $data = DB::table('api_clients')->get();

        dd($data);

        $info = DB::table('api_clients')->where(function ($query) use ($appKey, $appSecret) {
            $query->where(function ($q) use ($appKey, $appSecret) {
                $q->where('live_app_key', $appKey)
                    ->where('live_app_secret', $appSecret);
            })->orWhere(function ($q) use ($appKey, $appSecret) {
                $q->where('sandbox_app_key', $appKey)
                    ->where('sandbox_app_secret', $appSecret);
            });
        })->first();

        if (!$info) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return $next($request);
    }


}
