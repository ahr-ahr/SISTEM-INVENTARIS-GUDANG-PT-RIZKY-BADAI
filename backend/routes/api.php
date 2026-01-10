<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('throttle:login');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/items', [BarangController::class, 'index'])->middleware('throttle:login');

    /**Route::middleware('permission:inventory.view')
        ->get('/inventory', ...);*/
});