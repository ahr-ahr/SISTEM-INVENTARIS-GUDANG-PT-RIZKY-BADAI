<?php

namespace App\Http\Resources\Inventory\Alert;

use App\Http\Resources\BaseApiResource;

class StokMinimumResource extends BaseApiResource
{
    public function toArray($request): array
    {
        return [
            'barang_id'    => $this->int($this->id),
            'kode'         => $this->kode,
            'nama'         => $this->nama,
            'stok'         => $this->int($this->stok),
            'stok_minimum' => $this->int($this->stok_minimum),
            'selisih'      => $this->int($this->stok_minimum - $this->stok),
            'level'        => $this->stok === 0 ? 'KRITIS' : 'MENIPIS',
        ];
    }
}
