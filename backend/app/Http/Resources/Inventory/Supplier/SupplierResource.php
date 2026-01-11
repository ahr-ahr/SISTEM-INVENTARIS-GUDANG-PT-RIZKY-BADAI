<?php

namespace App\Http\Resources\Inventory\Supplier;

use App\Http\Resources\BaseApiResource;

class SupplierResource extends BaseApiResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->int($this->id),
            'kode'      => $this->kode,
            'nama'      => $this->nama,
            'telepon'   => $this->optional($this->telepon),
            'email'     => $this->optional($this->email),
            'alamat'    => $this->optional($this->alamat),
            'is_active' => $this->bool($this->is_active),
        ];
    }
}
