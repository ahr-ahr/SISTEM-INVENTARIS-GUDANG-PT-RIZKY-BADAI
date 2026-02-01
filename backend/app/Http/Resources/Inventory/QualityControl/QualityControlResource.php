<?php

namespace App\Http\Resources\Inventory\QualityControl;

use App\Http\Resources\BaseApiResource;

class QualityControlResource extends BaseApiResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->int($this->id),

            'status' => $this->status,

            'qty' => [
                'received' => $this->int($this->qty_received),
                'accepted' => $this->int($this->qty_accepted),
                'rejected' => $this->int($this->qty_rejected),
            ],

            'barang' => [
                'id'   => $this->barang_id,
                'kode' => $this->barang?->kode,
                'nama' => $this->barang?->nama,
            ],

            'warehouse' => [
                'id'   => $this->warehouse_id,
                'nama' => $this->warehouse?->nama,
            ],

            'location' => [
                'id'   => $this->location_id,
                'nama' => $this->location?->nama,
            ],

            'receiving_id' => $this->receiving_id,

            'requested_by' => [
                'id'   => $this->requested_by,
                'nama' => $this->requester?->name,
            ],

            'approved_by' => $this->approved_by
                ? [
                    'id'   => $this->approved_by,
                    'nama' => $this->approver?->name,
                ]
                : null,

            'rejected_by' => $this->rejected_by
                ? [
                    'id'   => $this->rejected_by,
                    'nama' => $this->rejector?->name,
                ]
                : null,

            'approved_at' => $this->approved_at,
            'rejected_at' => $this->rejected_at,
            'reject_reason' => $this->reject_reason,

            'created_at' => $this->created_at,
        ];
    }
}
