<?php

namespace App\Http\Resources\Inventory\Report;

use App\Http\Resources\BaseApiResource;

class StokSnapshotResource extends BaseApiResource
{
    public function toArray($request): array
    {
        return [
            'barang_id'     => $this->int($this->id),
            'kode'          => $this->kode,
            'nama'          => $this->nama,
            'stok'          => $this->int($this->stok),
            'stok_minimum'  => $this->int($this->stok_minimum),
            'status_stok'   => $this->stok <= $this->stok_minimum
                ? 'MENIPIS'
                : 'AMAN',
        ];
    }
}
