<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class TransaksiStok extends Model
{
    protected $table = 'transaksi_stok';

    protected $fillable = [
        'barang_id',
        'receiving_id',
        'dispatch_id',
        'adjustment_id',
        'jenis',
        'jumlah',
        'stok_sebelum',
        'stok_sesudah',
        'sumber',
        'keterangan',
        'user_id',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

?>