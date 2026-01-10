<?php

namespace App\Http\Resources\Inventory;

use Illuminate\Http\Request;
use App\Http\Resources\BaseApiResource;

class BarangResource extends BaseApiResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->int($this->id),
            'kode' => $this->kode,
            'nama' => $this->nama,
            'kategori' => $this->optional($this->kategori),
            'satuan' => $this->satuan,

            'stok' => $this->int($this->stok),
            'stok_minimum' => $this->int($this->stok_minimum),

            'deskripsi' => $this->optional($this->deskripsi),
            'is_active' => $this->bool($this->is_active),

            'deactivated' => $this->when(
                ! $this->is_active,
                [
                    'reason' => $this->deactivated_reason?->value,
                    'reason_label' => $this->deactivated_reason?->label(),
                    'at' => $this->isoDate($this->deactivated_at),
                    'by' => $this->int($this->deactivated_by),
                ]
            ),

            'created_at' => $this->isoDate($this->created_at),
            'updated_at' => $this->isoDate($this->updated_at),
        ];
    }
}
