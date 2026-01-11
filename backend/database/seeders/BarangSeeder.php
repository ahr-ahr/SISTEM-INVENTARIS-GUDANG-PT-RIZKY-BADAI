<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory\Barang;
use App\Models\Inventory\Category;
use App\Enums\BarangDeactivationReason;
use Illuminate\Support\Carbon;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        Barang::query()->delete();

        $besi = Category::where('nama', 'Besi')->firstOrFail();
        $cat  = Category::where('nama', 'Cat')->firstOrFail();
        $aks  = Category::where('nama', 'Aksesoris')->firstOrFail();

        Barang::insert([
            [
                'kode' => 'BRG-001',
                'nama' => 'Besi Hollow 4x4',
                'category_id' => $besi->id,
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
                'category_id' => $cat->id,
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
                'category_id' => $aks->id,
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
