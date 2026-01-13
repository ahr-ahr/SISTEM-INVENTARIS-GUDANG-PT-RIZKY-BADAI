<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class DecryptRequest
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('payload')) {
            try {
                $decrypted = Crypt::decrypt($request->payload);

                if (is_array($decrypted)) {
                    $request->merge($decrypted);
                }
            } catch (\Throwable $e) {
                return response()->json([
                    'message' => 'Invalid encrypted payload',
                ], 400);
            }
        }

        return $next($request);
    }
}
