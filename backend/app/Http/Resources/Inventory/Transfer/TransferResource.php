<?php

namespace App\Http\Resources\Inventory\Transfer;

use App\Http\Resources\BaseApiResource;

class TransferResource extends BaseApiResource
{
    public function toArray($request): array
    {
        return [
            'id'              => $this->int($this->id),
            'barang_id'       => $this->int($this->barang_id),
            'from_location_id'=> $this->int($this->from_location_id),
            'to_location_id'  => $this->int($this->to_location_id),
            'jumlah'          => $this->int($this->jumlah),
            'status'          => $this->status,
            'alasan'          => $this->alasan,
            'requested_by'    => $this->int($this->requested_by),
            'approved_by'     => $this->int($this->approved_by),
            'approved_at'     => $this->approved_at,
            'rejected_by'     => $this->int($this->rejected_by),
            'rejected_at'     => $this->rejected_at,
            'created_at'      => $this->created_at,
        ];
    }
}
