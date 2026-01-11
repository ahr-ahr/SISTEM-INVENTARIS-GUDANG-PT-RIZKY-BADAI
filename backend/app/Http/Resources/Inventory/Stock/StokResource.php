<?php

namespace App\Http\Resources\Inventory\Stock;

use App\Http\Resources\BaseApiResource;

class StokResource extends BaseApiResource
{
    public function toArray($request): array
    {
        return [
            'barang_id' => $this->int($this->id),
            'kode'      => $this->kode,
            'nama'      => $this->nama,
            'stok'      => $this->int($this->stok),
        ];
    }
}

?>