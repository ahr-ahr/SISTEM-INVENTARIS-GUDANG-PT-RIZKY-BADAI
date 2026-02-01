<?php

namespace App\Http\Resources\Inventory\Warehouse;

use App\Http\Resources\BaseApiResource;

class WarehouseResource extends BaseApiResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->int($this->id),
            'nama'      => $this->nama,
            'tipe'      => $this->tipe,
            'alamat'    => $this->alamat,
            'is_active' => (bool) $this->is_active,
            'created_at'=> $this->created_at?->toISOString(),
        ];
    }
}
