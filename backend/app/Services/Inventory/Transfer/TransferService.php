<?php

namespace App\Services\Inventory\Transfer;

use App\Models\Inventory\Transfer;
use App\Services\Inventory\Warehouse\WarehouseStockService;
use Illuminate\Support\Facades\DB;
use Exception;

class TransferService
{
    public function approve(
        Transfer $transfer,
        int $userId,
        WarehouseStockService $warehouseStockService
    ): void {
        DB::transaction(function () use ($transfer, $userId, $warehouseStockService) {

            if ($transfer->status !== 'PENDING') {
                throw new Exception('Transfer sudah diproses');
            }

            if ($transfer->from_location_id === $transfer->to_location_id) {
                throw new Exception('Lokasi asal dan tujuan tidak boleh sama');
            }

            $warehouseStockService->transfer(
                warehouseId: $transfer->warehouse_id,
                fromLocationId: $transfer->from_location_id,
                toLocationId: $transfer->to_location_id,
                barangId: $transfer->barang_id,
                jumlah: $transfer->jumlah
            );

            $transfer->update([
                'status'      => 'APPROVED',
                'approved_by' => $userId,
                'approved_at' => now(),
            ]);
        });
    }
}
