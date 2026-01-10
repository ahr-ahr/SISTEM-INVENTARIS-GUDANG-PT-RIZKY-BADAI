<?php

namespace App\Http\RateLimiters;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;

class LoginRateLimiter
{
    public static function register(): void
    {
        RateLimiter::for('login', function (Request $request) {
            $username = strtolower($request->input('username', 'guest'));

            return Limit::perMinute(5)->by(
                $username . '|' . $request->ip()
            );
        });
    }
}
