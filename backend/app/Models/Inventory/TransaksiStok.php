<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;

class TransaksiStok extends Model
{
    protected $table = 'transaksi_stok';

    protected $fillable = [
        'barang_id',
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
}

?>