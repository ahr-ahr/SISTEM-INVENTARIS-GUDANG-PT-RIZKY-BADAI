<?php

namespace App\Services\Inventory;

use App\Models\Inventory\Barang;
use App\Models\Inventory\TransaksiStok;
use Illuminate\Support\Facades\DB;
use Exception;

class StokService
{
    public function tambahStok(
        Barang $barang,
        int $jumlah,
        string $sumber,
        ?int $userId = null,
        ?string $keterangan = null
    ): Barang {
        return DB::transaction(function () use ($barang, $jumlah, $sumber, $userId, $keterangan) {
            $stokSebelum = $barang->stok;
            $stokSesudah = $stokSebelum + $jumlah;

            $barang->update(['stok' => $stokSesudah]);

            TransaksiStok::create([
                'barang_id'     => $barang->id,
                'jenis'         => 'MASUK',
                'jumlah'        => $jumlah,
                'stok_sebelum'  => $stokSebelum,
                'stok_sesudah'  => $stokSesudah,
                'sumber'        => $sumber,
                'keterangan'    => $keterangan,
                'user_id'       => $userId,
            ]);

            return $barang;
        });
    }

    public function kurangiStok(
        Barang $barang,
        int $jumlah,
        string $sumber,
        ?int $userId = null,
        ?string $keterangan = null
    ): Barang {
        if ($barang->stok < $jumlah) {
            throw new Exception('Stok tidak mencukupi');
        }

        return DB::transaction(function () use ($barang, $jumlah, $sumber, $userId, $keterangan) {
            $stokSebelum = $barang->stok;
            $stokSesudah = $stokSebelum - $jumlah;

            $barang->update(['stok' => $stokSesudah]);

            TransaksiStok::create([
                'barang_id'     => $barang->id,
                'jenis'         => 'KELUAR',
                'jumlah'        => $jumlah,
                'stok_sebelum'  => $stokSebelum,
                'stok_sesudah'  => $stokSesudah,
                'sumber'        => $sumber,
                'keterangan'    => $keterangan,
                'user_id'       => $userId,
            ]);

            return $barang;
        });
    }
}

?>