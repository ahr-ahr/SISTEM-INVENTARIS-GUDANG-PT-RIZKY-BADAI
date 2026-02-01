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
use App\Http\Controllers\Inventory\Dispatch\DispatchController;
use App\Events\BarangMasuk;
use App\Http\Controllers\Inventory\Transfer\TransferController;
use App\Http\Controllers\Inventory\Warehouse\WarehouseController;
use App\Http\Controllers\Inventory\Warehouse\WarehouseLocationController;
use App\Http\Controllers\Inventory\Warehouse\WarehouseStockController;
use App\Http\Controllers\Inventory\QualityControl\QualityControlController;

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
                Route::post('adjustment/{adjustment}/approve', [StockAdjustmentController::class, 'approve']);
                Route::post('adjustment/{adjustment}/reject', [StockAdjustmentController::class, 'reject']);
                Route::post('dispatch', [DispatchController::class, 'store']);
                Route::post('dispatches/{dispatch}/approve', [DispatchController::class, 'approve']);
                Route::post('dispatches/{dispatch}/reject',  [DispatchController::class, 'reject']);
                Route::post('receivings', [ReceivingController::class, 'store']);
                Route::post('receivings/{receiving}/approve',[ReceivingController::class, 'approve']);
                Route::post('receivings/{receiving}/reject',[ReceivingController::class, 'reject']);
                Route::prefix('transfers')->group(function () {
                    Route::post('/', [
                        TransferController::class,
                        'store'
                    ]);
                    Route::post('{transfer}/approve', [
                        TransferController::class,
                        'approve'
                    ]);
                    Route::post('{transfer}/reject', [
                        TransferController::class,
                        'reject'
                    ]);
                });
                Route::apiResource('warehouses', WarehouseController::class);
                Route::apiResource('warehouse-locations', WarehouseLocationController::class);
                Route::prefix('warehouse-stocks')->group(function () {
                    Route::get('/', [WarehouseStockController::class, 'index']);
                    Route::post('/increase', [WarehouseStockController::class, 'increase']);
                    Route::post('/decrease', [WarehouseStockController::class, 'decrease']);
                    Route::post('/reserve', [WarehouseStockController::class, 'reserve']);
                    Route::post('/transfer', [WarehouseStockController::class, 'transfer']);
                    Route::post('/mark-damaged', [WarehouseStockController::class, 'markDamaged']);
                });
                Route::prefix('qc')->group(function () {
                    Route::get('/', [QualityControlController::class, 'index']);
                    Route::post('/', [QualityControlController::class, 'store']);
                    Route::get('/{qc}', [QualityControlController::class, 'show']);
                    Route::post('/{qc}/approve', [QualityControlController::class, 'approve']);
                    Route::post('/{qc}/reject', [QualityControlController::class, 'reject']);
                });
            });
    });
});
