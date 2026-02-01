<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Inventory\Receiving;
use App\Models\Inventory\Barang;
use App\Models\Inventory\Warehouses\Warehouse;
use App\Models\Inventory\Warehouses\WarehouseLocation;
use App\Models\User;

class QualityControl extends Model
{
    use HasFactory;

    protected $table = 'quality_controls';

    protected $fillable = [
        'receiving_id',
        'barang_id',
        'warehouse_id',
        'location_id',
        'qty_received',
        'qty_accepted',
        'qty_rejected',
        'status',
        'requested_by',
        'approved_by',
        'approved_at',
        'rejected_by',
        'rejected_at',
        'reject_reason',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    /* =====================
     | RELATIONS
     |===================== */

    public function receiving()
    {
        return $this->belongsTo(Receiving::class);
    }

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

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejector()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }
}
