<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use App\Support\ApiMeta;

class Handler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response (API ONLY).
     */
    public function render($request, Throwable $e): JsonResponse
    {
        $meta = ApiMeta::withTimestamp();

        // VALIDATION ERROR
        if ($e instanceof ValidationException) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors'  => $e->errors(),
                'meta'    => $meta,
            ], 422);
        }

        // UNAUTHENTICATED
        if ($e instanceof AuthenticationException) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated',
                'meta'    => $meta,
            ], 401);
        }

        // HTTP EXCEPTION (404, 403, dll)
        if ($e instanceof HttpExceptionInterface) {
            return response()->json([
                'success' => false,
                'message' => match ($e->getStatusCode()) {
                    404 => 'Endpoint not found',
                    403 => 'Forbidden',
                    401 => 'Unauthorized',
                    default => 'HTTP error',
                },
                'meta' => $meta,
            ], $e->getStatusCode());
        }

        // INTERNAL SERVER ERROR
        return response()->json([
            'success' => false,
            'message' => app()->isProduction()
                ? 'Internal server error'
                : $e->getMessage(),
            'meta' => $meta,
        ], 500);
    }
}
