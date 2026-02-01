<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Receiving extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'warehouse_id',
        'location_id',
        'barang_id',
        'jumlah',
        'keterangan',
        'status',
        'user_id',
        'approved_by',
        'approved_at',
        'rejected_by',
        'rejected_at',
        'reject_reason',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
