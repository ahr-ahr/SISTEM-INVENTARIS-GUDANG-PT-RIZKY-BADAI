<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Dispatch extends Model
{
    protected $fillable = [
        'barang_id',
        'warehouse_id',
        'location_id',
        'jumlah',
        'tujuan',
        'keterangan',
        'status',
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

?>