<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(LoginRequest $request, AuthService $authService)
    {
        $result = $authService->login($request->validated());

        return response()->json(
            [
                'message' => 'Login berhasil',
                'data'    => new AuthResource($result),
                'meta'    => AuthResource::meta(),
            ],
            201,
            [],
            JSON_UNESCAPED_UNICODE
        );
    }

    public function logout(Request $request, AuthService $authService)
    {
        $authService->logout($request->user());

        return response()->json([
            'message' => 'Logout berhasil',
        ]);
    }
}
