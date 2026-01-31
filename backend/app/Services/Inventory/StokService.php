<?php

namespace App\Services\Inventory;

use App\Models\Inventory\Barang;
use App\Models\Inventory\TransaksiStok;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Events\Inventory\StokMinimumReached;

class StokService
{
    public function tambahStok(
        Barang $barang,
        int $jumlah,
        string $sumber,
        ?int $userId = null,
        ?string $keterangan = null,
        ?int $receivingId = null
    ): Barang {
        return DB::transaction(function () use ($barang, $jumlah, $sumber, $userId, $keterangan, $receivingId) {
            $stokSebelum = $barang->stok;
            $stokSesudah = $stokSebelum + $jumlah;

            $barang->update(['stok' => $stokSesudah]);

            TransaksiStok::create([
                'barang_id'     => $barang->id,
                'receiving_id' => $receivingId,
                'jenis'         => 'MASUK',
                'jumlah'        => $jumlah,
                'stok_sebelum'  => $stokSebelum,
                'stok_sesudah'  => $stokSesudah,
                'sumber'        => $sumber,
                'keterangan'    => $keterangan,
                'user_id'       => $userId,
            ]);

            if (
                $stokSesudah <= $barang->stok_minimum &&
                $stokSebelum > $barang->stok_minimum
            ) {
                event(new StokMinimumReached($barang));
            }

            return $barang;
        });
    }

    public function kurangiStok(
        Barang $barang,
        int $jumlah,
        string $sumber,
        ?int $userId = null,
        ?string $keterangan = null,
        ?int $dispatchId = null
    ): Barang {
        if ($barang->stok < $jumlah) {
            throw new Exception('Stok tidak mencukupi');
        }

        return DB::transaction(function () use ($barang, $jumlah, $sumber, $userId, $keterangan, $dispatchId) {
            $stokSebelum = $barang->stok;
            $stokSesudah = $stokSebelum - $jumlah;

            $barang->update(['stok' => $stokSesudah]);

            TransaksiStok::create([
                'barang_id'     => $barang->id,
                'dispatch_id' => $dispatchId,
                'jenis'         => 'KELUAR',
                'jumlah'        => $jumlah,
                'stok_sebelum'  => $stokSebelum,
                'stok_sesudah'  => $stokSesudah,
                'sumber'        => $sumber,
                'keterangan'    => $keterangan,
                'user_id'       => $userId,
            ]);

            if (
                $stokSesudah <= $barang->stok_minimum &&
                $stokSebelum > $barang->stok_minimum
            ) {
                event(new StokMinimumReached($barang));
            }

            return $barang;
        });
    }
}

?>