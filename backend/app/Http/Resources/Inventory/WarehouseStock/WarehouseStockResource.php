<?php

namespace App\Http\Resources\Inventory\Warehouse;

use App\Http\Resources\BaseApiResource;

class WarehouseStockResource extends BaseApiResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->int($this->id),

            'warehouse' => [
                'id'   => $this->int($this->warehouse_id),
                'nama' => $this->warehouse?->nama,
            ],

            'location' => [
                'id'   => $this->int($this->location_id),
                'kode' => $this->location?->kode,
                'nama' => $this->location?->nama,
            ],

            'barang' => [
                'id'   => $this->int($this->barang_id),
                'kode' => $this->barang?->kode,
                'nama' => $this->barang?->nama,
            ],

            'stok' => [
                'available' => $this->int($this->stok),
                'reserved'  => $this->int($this->stok_reserved),
                'damaged'   => $this->int($this->stok_damaged),
                'total'     => $this->int(
                    $this->stok + $this->stok_reserved + $this->stok_damaged
                ),
            ],

            'updated_at' => $this->dateTime($this->updated_at),
        ];
    }
}
