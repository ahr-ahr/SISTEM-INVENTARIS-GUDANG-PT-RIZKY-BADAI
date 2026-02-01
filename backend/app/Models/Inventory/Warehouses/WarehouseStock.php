<?php

namespace App\Models\Inventory\Warehouses;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Inventory\Barang;

class WarehouseStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'location_id',
        'barang_id',
        'stok',
        'stok_reserved',
        'stok_damaged',
    ];

    protected $casts = [
        'stok'          => 'integer',
        'stok_reserved' => 'integer',
        'stok_damaged'  => 'integer',
    ];

    /* =====================
     | RELATIONS
     |=====================*/

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function location()
    {
        return $this->belongsTo(WarehouseLocation::class, 'location_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
