<?php

namespace App\Http\Resources\Inventory\Receiving;

use App\Http\Resources\BaseApiResource;
use App\Http\Resources\Inventory\Stock\StokResource;

class ReceivingResource extends BaseApiResource
{
    public function toArray($request): array
    {
        return [
            'id'     => $this->id,
            'kode'   => $this->kode ?? null,
            'status' => $this->status,

            'jumlah' => $this->int($this->jumlah),

            'supplier' => [
                'id'   => $this->supplier_id,
                'nama' => $this->supplier?->nama,
            ],

            'barang' => new StokResource($this->barang),

            'requested_by' => $this->requested_by,
            'approved_by'  => $this->approved_by,
            'rejected_by'  => $this->rejected_by,

            'created_at'   => $this->created_at,
            'approved_at'  => $this->approved_at,
            'rejected_at'  => $this->rejected_at,
            'reject_reason'=> $this->reject_reason,
        ];
    }
}
