<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class EncryptResponse
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $content = $response->getOriginalContent();

        if (is_array($content)) {
            return response()->json([
                'payload' => Crypt::encrypt($content),
            ], $response->status());
        }

        return $response;
    }
}
