<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\HandleCors;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\DecryptRequest;
use App\Http\Middleware\EncryptResponse;
use Illuminate\Http\Request;
use App\Exceptions\Handler;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        /**
         * =================================================
         * API Middleware (Laravel 12 + Sanctum SPA)
         * =================================================
         */
        $middleware->api(prepend: [
            EnsureFrontendRequestsAreStateful::class,
            ForceJsonResponse::class,
            DecryptRequest::class,
            EncryptResponse::class,
        ]);

        /**
         * =================================================
         * Global Middleware
         * =================================================
         */
        $middleware->append(HandleCors::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(
            fn (Throwable $e, Request $request) =>
                app(Handler::class)->render($request, $e)
        );
    })
    ->create();
