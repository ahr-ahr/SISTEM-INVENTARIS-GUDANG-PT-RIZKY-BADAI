<?php

namespace App\Http\Resources\Inventory\Category;

use App\Http\Resources\BaseApiResource;

class CategoryResource extends BaseApiResource
{
    public function toArray($request): array
    {
        return [
            'id'        => $this->int($this->id),
            'kode'      => $this->kode,
            'nama'      => $this->nama,
            'deskripsi' => $this->optional($this->deskripsi),
            'is_active' => $this->bool($this->is_active),
        ];
    }
}
