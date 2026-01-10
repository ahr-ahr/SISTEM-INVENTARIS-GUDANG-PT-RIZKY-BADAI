<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Inventory\BarangController;
use App\Enums\BarangDeactivationReason;

Route::prefix('v1')->group(function () {

    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::prefix('inventory')->group(function () {

            Route::get('barangs/deactivation-reasons',[BarangController::class, 'deactivationReasons']);
            Route::get('barangs/inactive', [BarangController::class, 'inactive']);
            Route::apiResource('barangs', BarangController::class);
        });
    });
});
