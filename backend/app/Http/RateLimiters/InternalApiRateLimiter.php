<?php

namespace App\Http\RateLimiters;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;

class InternalApiRateLimiter
{
    public static function register(): void
    {
        RateLimiter::for('internal-api', function (Request $request) {
            return Limit::perMinute(120)->by(
                $request->user()?->id ?? $request->ip()
            );
        });
    }
}
