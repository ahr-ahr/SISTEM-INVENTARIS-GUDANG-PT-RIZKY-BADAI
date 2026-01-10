<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\BarangDeactivationReason;

class Barang extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'kategori',
        'satuan',
        'stok',
        'stok_minimum',
        'deskripsi',
        'is_active',
        'deactivated_reason',
        'deactivated_at',
        'deactivated_by',
    ];

    protected $casts = [
        'stok' => 'integer',
        'stok_minimum' => 'integer',
        'is_active' => 'boolean',
        'deactivated_at' => 'datetime',
        'deactivated_reason' => BarangDeactivationReason::class,
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }
    
    public function deactivatedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'deactivated_by');
    }
}