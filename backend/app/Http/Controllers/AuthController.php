<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Support\ApiMeta;
use App\Support\HttpStatus;
use App\Support\HttpMessage;

class AuthController extends Controller
{
    public function login(LoginRequest $request, AuthService $authService)
{
    $result = $authService->login($request->validated());

    return response()->json([
        'success' => true,
        'message' => HttpMessage::fromStatus(HttpStatus::OK),
        'data'    => new AuthResource($result),
        'meta'    => ApiMeta::withTimestamp(),
    ], HttpStatus::OK);
}

public function logout(Request $request, AuthService $authService)
{
    $authService->logout($request->user());

    return response()->json([
        'success' => true,
        'message' => HttpMessage::fromStatus(HttpStatus::OK),
        'meta'    => ApiMeta::withTimestamp(),
    ], HttpStatus::OK);
}
}
