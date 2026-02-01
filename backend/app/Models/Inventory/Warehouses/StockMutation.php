<?php

namespace App\Models\Inventory\Warehouses;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockMutation extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',
        'warehouse_id',
        'location_id',
        'tipe',
        'sumber',
        'ref_type',
        'ref_id',
        'qty',
        'stok_sebelum',
        'stok_sesudah',
        'user_id',
    ];

    protected $casts = [
        'qty'          => 'integer',
        'stok_sebelum' => 'integer',
        'stok_sesudah' => 'integer',
    ];

    /* =====================
     | RELATIONS
     |=====================*/

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function location()
    {
        return $this->belongsTo(WarehouseLocation::class, 'location_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
