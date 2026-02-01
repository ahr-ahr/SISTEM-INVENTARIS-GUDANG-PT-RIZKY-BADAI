<?php

namespace App\Models\Inventory\Warehouses;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WarehouseLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'parent_id',
        'nama',
        'level',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /* =====================
     | RELATIONS
     |=====================*/

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function stocks()
    {
        return $this->hasMany(WarehouseStock::class, 'location_id');
    }
}
