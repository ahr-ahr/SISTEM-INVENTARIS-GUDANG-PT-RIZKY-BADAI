<?php

namespace App\Http\RateLimiters;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;

class SensitiveActionRateLimiter
{
    public static function register(): void
    {
        RateLimiter::for('sensitive-action', function (Request $request) {
            return Limit::perMinute(30)->by(
                $request->user()?->id ?? $request->ip()
            );
        });
    }
}