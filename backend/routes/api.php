<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Inventory\BarangController;
use App\Enums\BarangDeactivationReason;
use App\Http\Controllers\Inventory\PenerimaanController;
use App\Http\Controllers\Inventory\PengeluaranController;
use App\Http\Controllers\Inventory\Report\LaporanMutasiStokController;
use App\Http\Controllers\Inventory\Report\LaporanStokController;
use App\Http\Controllers\Inventory\Alert\StokMinimumController;
use App\Http\Controllers\Inventory\Adjustment\StockAdjustmentController;
use App\Http\Controllers\Inventory\Category\CategoryController;
use App\Http\Controllers\Inventory\Supplier\SupplierController;
use App\Http\Controllers\Inventory\Receiving\ReceivingController;
use App\Events\BarangMasuk;

Route::prefix('v1')->group(function () {
Route::get('/test-realtime', function () {
    broadcast(new BarangMasuk([
        'kode' => 'BRG-001',
        'nama' => 'Baut Baja',
        'qty'  => 10,
    ]));

    return 'Event BarangMasuk dikirim';
});

    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::prefix('inventory')
            ->middleware('throttle:internal-api')
            ->group(function () {
                Route::apiResource('categories', CategoryController::class)->except(['show']);
                Route::apiResource('suppliers', SupplierController::class)->except(['show']);
                Route::get('barangs/deactivation-reasons', [BarangController::class, 'deactivationReasons']);
                Route::get('barangs/inactive', [BarangController::class, 'inactive']);
                Route::apiResource('barangs', BarangController::class);

                Route::post('penerimaan', [PenerimaanController::class, 'store']);
                Route::post('pengeluaran', [PengeluaranController::class, 'store']);

                Route::get('laporan/mutasi-stok', [LaporanMutasiStokController::class, 'index']);
                Route::get('laporan/stok', [LaporanStokController::class, 'index']);
                Route::get('alert/stok-minimum', [StokMinimumController::class, 'index']);
                Route::post('adjustment', [StockAdjustmentController::class, 'store']);
                Route::post('receivings', [ReceivingController::class, 'store']);
            });
    });
});
