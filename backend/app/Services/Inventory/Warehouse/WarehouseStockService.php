<?php

namespace App\Services\Inventory\Warehouse;

use App\Models\Inventory\Warehouses\WarehouseStock;
use Illuminate\Support\Facades\DB;
use Exception;

class WarehouseStockService
{
    /**
     * Ambil atau buat stock record (atomic)
     */
    protected function getStock(
        int $warehouseId,
        int $locationId,
        int $barangId
    ): WarehouseStock {
        return WarehouseStock::lockForUpdate()->firstOrCreate(
            [
                'warehouse_id' => $warehouseId,
                'location_id'  => $locationId,
                'barang_id'    => $barangId,
            ],
            [
                'stok'          => 0,
                'stok_reserved' => 0,
                'stok_damaged'  => 0,
            ]
        );
    }

    /* =====================
     | INBOUND (RECEIVING)
     |=====================*/
    public function increase(
        int $warehouseId,
        int $locationId,
        int $barangId,
        int $jumlah
    ): WarehouseStock {
        return DB::transaction(function () use ($warehouseId, $locationId, $barangId, $jumlah) {

            $stock = $this->getStock($warehouseId, $locationId, $barangId);

            $stock->increment('stok', $jumlah);

            return $stock->refresh();
        });
    }

    /* =====================
     | OUTBOUND (DISPATCH)
     |=====================*/
    public function decrease(
        int $warehouseId,
        int $locationId,
        int $barangId,
        int $jumlah
    ): WarehouseStock {
        return DB::transaction(function () use ($warehouseId, $locationId, $barangId, $jumlah) {

            $stock = $this->getStock($warehouseId, $locationId, $barangId);

            if ($stock->stok < $jumlah) {
                throw new Exception('Stok warehouse tidak mencukupi');
            }

            $stock->decrement('stok', $jumlah);

            return $stock->refresh();
        });
    }

    /* =====================
     | RESERVE STOCK
     |=====================*/
    public function reserve(
        int $warehouseId,
        int $locationId,
        int $barangId,
        int $jumlah
    ): WarehouseStock {
        return DB::transaction(function () use ($warehouseId, $locationId, $barangId, $jumlah) {

            $stock = $this->getStock($warehouseId, $locationId, $barangId);

            if ($stock->stok < $jumlah) {
                throw new Exception('Stok tidak cukup untuk di-reserve');
            }

            $stock->decrement('stok', $jumlah);
            $stock->increment('stok_reserved', $jumlah);

            return $stock->refresh();
        });
    }

    /* =====================
     | RELEASE RESERVED
     |=====================*/
    public function release(
        int $warehouseId,
        int $locationId,
        int $barangId,
        int $jumlah
    ): WarehouseStock {
        return DB::transaction(function () use ($warehouseId, $locationId, $barangId, $jumlah) {

            $stock = $this->getStock($warehouseId, $locationId, $barangId);

            if ($stock->stok_reserved < $jumlah) {
                throw new Exception('Reserved stock tidak mencukupi');
            }

            $stock->decrement('stok_reserved', $jumlah);
            $stock->increment('stok', $jumlah);

            return $stock->refresh();
        });
    }

    /* =====================
     | TRANSFER LOCATION
     |=====================*/
    public function transfer(
        int $warehouseId,
        int $fromLocationId,
        int $toLocationId,
        int $barangId,
        int $jumlah
    ): void {
        DB::transaction(function () use (
            $warehouseId,
            $fromLocationId,
            $toLocationId,
            $barangId,
            $jumlah
        ) {
            if ($fromLocationId === $toLocationId) {
                throw new Exception('Lokasi asal dan tujuan tidak boleh sama');
            }

            $from = $this->getStock($warehouseId, $fromLocationId, $barangId);
            $to   = $this->getStock($warehouseId, $toLocationId, $barangId);

            if ($from->stok < $jumlah) {
                throw new Exception('Stok sumber tidak mencukupi untuk transfer');
            }

            $from->decrement('stok', $jumlah);
            $to->increment('stok', $jumlah);
        });
    }

    /* =====================
     | DAMAGED / QC
     |=====================*/
    public function markDamaged(
        int $warehouseId,
        int $locationId,
        int $barangId,
        int $jumlah
    ): WarehouseStock {
        return DB::transaction(function () use ($warehouseId, $locationId, $barangId, $jumlah) {

            $stock = $this->getStock($warehouseId, $locationId, $barangId);

            if ($stock->stok < $jumlah) {
                throw new Exception('Stok tidak cukup untuk ditandai rusak');
            }

            $stock->decrement('stok', $jumlah);
            $stock->increment('stok_damaged', $jumlah);

            return $stock->refresh();
        });
    }
}
