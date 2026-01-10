<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\RateLimiters\LoginRateLimiter;
use App\Http\RateLimiters\InternalApiRateLimiter;
use App\Http\RateLimiters\SensitiveActionRateLimiter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        LoginRateLimiter::register();
        InternalApiRateLimiter::register();
        SensitiveActionRateLimiter::register();
    }
}
