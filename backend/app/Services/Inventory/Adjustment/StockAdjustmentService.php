<?php

namespace App\Services\Inventory\Adjustment;

use App\Models\Inventory\StockAdjustment;
use App\Models\Inventory\Barang;
use App\Models\Inventory\TransaksiStok;
use App\Models\Inventory\Warehouses\WarehouseStock;
use App\Services\Inventory\Warehouse\WarehouseStockService;
use Illuminate\Support\Facades\DB;
use Exception;

class StockAdjustmentService
{
    public function __construct(
        protected WarehouseStockService $warehouseStockService
    ) {}

    public function adjust(
        StockAdjustment $adjustment,
        int $userId
    ): void {
        DB::transaction(function () use ($adjustment, $userId) {

            if ($adjustment->status !== 'PENDING') {
                throw new Exception('Adjustment sudah diproses');
            }

            $selisih = $adjustment->selisih;

            if ($selisih > 0) {
                $this->warehouseStockService->increase(
                    $adjustment->warehouse_id,
                    $adjustment->location_id,
                    $adjustment->barang_id,
                    $selisih
                );
            } elseif ($selisih < 0) {
                $this->warehouseStockService->decrease(
                    $adjustment->warehouse_id,
                    $adjustment->location_id,
                    $adjustment->barang_id,
                    abs($selisih)
                );
            }

            $totalStok = WarehouseStock::where('barang_id', $adjustment->barang_id)
                ->sum('stok');

            Barang::where('id', $adjustment->barang_id)
                ->update(['stok' => $totalStok]);

            TransaksiStok::create([
                'barang_id'     => $adjustment->barang_id,
                'adjustment_id' => $adjustment->id,
                'jenis'         => $selisih > 0 ? 'MASUK' : 'KELUAR',
                'jumlah'        => abs($selisih),
                'stok_sebelum'  => $totalStok - $selisih,
                'stok_sesudah'  => $totalStok,
                'sumber'        => 'PENYESUAIAN',
                'keterangan'    => $adjustment->alasan,
                'user_id'       => $userId,
            ]);

            $adjustment->update([
                'status'      => 'APPROVED',
                'approved_by' => $userId,
                'approved_at' => now(),
            ]);
        });
    }
}
