<?php

namespace App\Models\Inventory\Warehouses;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'tipe',
        'alamat',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /* =====================
     | RELATIONS
     |=====================*/

    public function locations()
    {
        return $this->hasMany(WarehouseLocation::class);
    }

    public function stocks()
    {
        return $this->hasMany(WarehouseStock::class);
    }
}
