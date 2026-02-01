<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'barang_id',
        'warehouse_id',
        'from_location_id',
        'to_location_id',
        'jumlah',
        'status',
        'alasan',
        'requested_by',
        'approved_by',
        'approved_at',
        'rejected_by',
        'rejected_at',
        'reject_reason',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
