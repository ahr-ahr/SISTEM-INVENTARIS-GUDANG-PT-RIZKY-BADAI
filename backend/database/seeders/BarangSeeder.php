<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory\Barang;
use App\Enums\BarangDeactivationReason;
use Illuminate\Support\Carbon;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        Barang::truncate(); // optional (pakai kalau dev only)

        Barang::insert([
    [
        'kode' => 'BRG-001',
        'nama' => 'Besi Hollow 4x4',
        'kategori' => 'Besi',
        'satuan' => 'pcs',
        'stok' => 100,
        'stok_minimum' => 20,
        'deskripsi' => 'Besi hollow untuk konstruksi',
        'is_active' => true,

        'deactivated_reason' => null,
        'deactivated_at' => null,
        'deactivated_by' => null,

        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'kode' => 'BRG-002',
        'nama' => 'Cat Tembok Putih',
        'kategori' => 'Cat',
        'satuan' => 'kaleng',
        'stok' => 0,
        'stok_minimum' => 5,
        'deskripsi' => 'Cat tembok warna putih 5kg',
        'is_active' => false,

        'deactivated_reason' => BarangDeactivationReason::EXPIRED->value,
        'deactivated_at' => Carbon::now()->subDays(10),
        'deactivated_by' => 1,

        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'kode' => 'BRG-003',
        'nama' => 'Paku Beton 5cm',
        'kategori' => 'Aksesoris',
        'satuan' => 'kg',
        'stok' => 50,
        'stok_minimum' => 10,
        'deskripsi' => 'Paku beton ukuran 5cm',
        'is_active' => true,

        'deactivated_reason' => null,
        'deactivated_at' => null,
        'deactivated_by' => null,

        'created_at' => now(),
        'updated_at' => now(),
    ],
]);
    }
}
