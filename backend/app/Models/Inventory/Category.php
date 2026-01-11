<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'is_active',
    ];

    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }
}
