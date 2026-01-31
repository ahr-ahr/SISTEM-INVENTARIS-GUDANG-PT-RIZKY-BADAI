<?php

namespace App\Services\Inventory\Adjustment;

use App\Models\Inventory\Barang;
use App\Models\Inventory\TransaksiStok;
use Illuminate\Support\Facades\DB;
use Exception;

class StockAdjustmentService
{
    public function adjust(
        Barang $barang,
        int $stokFisik,
        string $alasan,
        ?int $userId = null,
        ?int $adjustmentId = null
    ): Barang {
        return DB::transaction(function () use ($barang, $stokFisik, $alasan, $userId, $adjustmentId) {

            $stokSistem = $barang->stok;
            $selisih    = $stokFisik - $stokSistem;

            // if ($selisih === 0) {
            //     throw new Exception('Tidak ada selisih stok untuk disesuaikan');
            // }

            if ($selisih === 0) {
                return $barang;
            }

            $jenis = $selisih > 0 ? 'MASUK' : 'KELUAR';

            $stokSesudah = $stokSistem + $selisih;

            $barang->update([
                'stok' => $stokSesudah,
            ]);

            TransaksiStok::create([
                'barang_id'     => $barang->id,
                'adjustment_id' => $adjustmentId,
                'jenis'         => $jenis,
                'jumlah'        => abs($selisih),
                'stok_sebelum'  => $stokSistem,
                'stok_sesudah'  => $stokSesudah,
                'sumber'        => 'PENYESUAIAN',
                'keterangan'    => $alasan,
                'user_id'       => $userId,
            ]);

            return $barang;
        });
    }
}
