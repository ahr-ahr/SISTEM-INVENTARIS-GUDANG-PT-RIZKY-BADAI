<?php

namespace App\Http\Resources\Inventory\Report;

use App\Http\Resources\BaseApiResource;

class StokSnapshotResource extends BaseApiResource
{
    public function toArray($request): array
    {
        $stok       = (int) $this->stok;
        $stokMin    = (int) ($this->barang?->stok_minimum ?? 0);

        return [
            // Identitas
            'warehouse' => [
                'id'   => $this->warehouse_id,
                'nama' => $this->warehouse?->nama,
            ],

            'location' => [
                'id'   => $this->location_id,
                'nama' => $this->location?->nama,
            ],

            // Barang
            'barang' => [
                'id'            => $this->barang_id,
                'kode'          => $this->barang?->kode,
                'nama'          => $this->barang?->nama,
                'stok_minimum'  => $stokMin,
            ],

            // Stok
            'stok'         => $stok,
            'stok_reserved'=> (int) $this->stok_reserved,
            'stok_damaged' => (int) $this->stok_damaged,

            // Status
            'status_stok' => $stok <= $stokMin
                ? 'MENIPIS'
                : 'AMAN',
        ];
    }
}
