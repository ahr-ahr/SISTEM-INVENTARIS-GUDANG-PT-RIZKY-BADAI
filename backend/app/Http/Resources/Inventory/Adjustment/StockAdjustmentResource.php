<?php

namespace App\Http\Resources\Inventory\Adjustment;

use App\Http\Resources\BaseApiResource;
use App\Http\Resources\Inventory\Stock\StokResource;

class StockAdjustmentResource extends BaseApiResource
{
    public function toArray($request): array
    {
        return [
            'id'     => $this->id,
            'status' => $this->status,

            'stok_sistem' => $this->int($this->stok_sistem),
            'stok_fisik'  => $this->int($this->stok_fisik),
            'selisih'     => $this->int($this->selisih),

            'alasan' => $this->alasan,

            'barang' => new StokResource($this->barang),

            'requested_by' => $this->requested_by,
            'approved_by'  => $this->approved_by,
            'rejected_by'  => $this->rejected_by,

            'created_at'  => $this->created_at,
            'approved_at' => $this->approved_at,
            'rejected_at' => $this->rejected_at,
            'reject_reason' => $this->reject_reason,
        ];
    }
}
