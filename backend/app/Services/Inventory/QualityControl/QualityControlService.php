<?php

namespace App\Services\Inventory\QualityControl;

use App\Models\Inventory\QualityControl;
use App\Models\Inventory\Barang;
use App\Models\Inventory\TransaksiStok;
use App\Services\Inventory\Warehouse\WarehouseStockService;
use Illuminate\Support\Facades\DB;
use Exception;

class QualityControlService
{
    public function __construct(
        protected WarehouseStockService $warehouseStockService
    ) {}

    /**
     * APPROVE QC
     * - stok masuk setelah QC
     * - accepted -> stok
     * - rejected -> stok_damaged
     */
    public function approve(
        QualityControl $qc,
        int $qtyAccepted,
        int $qtyRejected,
        int $userId
    ): void {
        DB::transaction(function () use ($qc, $qtyAccepted, $qtyRejected, $userId) {

            if ($qc->status !== 'PENDING') {
                throw new Exception('QC sudah diproses');
            }

            if ($qtyAccepted < 0 || $qtyRejected < 0) {
                throw new Exception('Jumlah QC tidak boleh negatif');
            }

            if (($qtyAccepted + $qtyRejected) !== $qc->qty_received) {
                throw new Exception('Jumlah QC tidak sesuai dengan jumlah diterima');
            }

            /*
            |--------------------------------------------------------------------------
            | UPDATE QC
            |--------------------------------------------------------------------------
            */
            $qc->update([
                'qty_accepted' => $qtyAccepted,
                'qty_rejected' => $qtyRejected,
                'status'       => 'APPROVED',
                'approved_by'  => $userId,
                'approved_at'  => now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | STOK USABLE
            |--------------------------------------------------------------------------
            */
            if ($qtyAccepted > 0) {
                $this->warehouseStockService->increase(
                    $qc->warehouse_id,
                    $qc->location_id,
                    $qc->barang_id,
                    $qtyAccepted
                );

                $this->logTransaksi(
                    $qc,
                    'MASUK',
                    $qtyAccepted,
                    'QC_ACCEPTED',
                    $userId
                );
            }

            /*
            |--------------------------------------------------------------------------
            | STOK DAMAGED
            |--------------------------------------------------------------------------
            */
            if ($qtyRejected > 0) {
                $stock = $this->warehouseStockService->markDamaged(
                    $qc->warehouse_id,
                    $qc->location_id,
                    $qc->barang_id,
                    $qtyRejected
                );

                $this->logTransaksi(
                    $qc,
                    'MASUK',
                    $qtyRejected,
                    'QC_REJECTED',
                    $userId
                );
            }

            /*
            |--------------------------------------------------------------------------
            | UPDATE AGGREGATE BARANG (OPTIONAL TAPI KONSISTEN)
            |--------------------------------------------------------------------------
            | barangs.stok = aggregate (summary)
            */
            if ($qtyAccepted > 0) {
                $barang = Barang::lockForUpdate()->findOrFail($qc->barang_id);
                $barang->increment('stok', $qtyAccepted);
            }
        });
    }

    /**
     * REJECT QC
     * - tidak ada perubahan stok
     */
    public function reject(
        QualityControl $qc,
        string $alasan,
        int $userId
    ): void {
        DB::transaction(function () use ($qc, $alasan, $userId) {

            if ($qc->status !== 'PENDING') {
                throw new Exception('QC sudah diproses');
            }

            $qc->update([
                'status'        => 'REJECTED',
                'rejected_by'   => $userId,
                'rejected_at'   => now(),
                'reject_reason' => $alasan,
            ]);
        });
    }

    /**
     * Catat transaksi stok (ledger)
     */
    protected function logTransaksi(
        QualityControl $qc,
        string $jenis,
        int $jumlah,
        string $sumber,
        int $userId
    ): void {
        $barang = Barang::lockForUpdate()->findOrFail($qc->barang_id);

        $stokSebelum = $barang->stok;
        $stokSesudah = $jenis === 'MASUK'
            ? $stokSebelum + $jumlah
            : $stokSebelum - $jumlah;

        TransaksiStok::create([
            'barang_id'     => $qc->barang_id,
            'jenis'         => $jenis,
            'jumlah'        => $jumlah,
            'stok_sebelum'  => $stokSebelum,
            'stok_sesudah'  => $stokSesudah,
            'sumber'        => $sumber,
            'keterangan'    => 'QC Receiving #' . $qc->receiving_id,
            'user_id'       => $userId,
        ]);
    }
}
