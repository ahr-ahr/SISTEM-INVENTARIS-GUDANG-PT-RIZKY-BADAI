<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory\Warehouses\Warehouse;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        Warehouse::query()->delete();

        Warehouse::insert([
            [
                'nama'       => 'Gudang Utama',
                'tipe'       => 'MAIN',
                'alamat'     => 'Jl. Industri No. 1, Jakarta',
                'is_active'  => true,
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'nama'       => 'Gudang Cabang Bandung',
                'tipe'       => 'BRANCH',
                'alamat'     => 'Jl. Raya Bandung No. 88, Bandung',
                'is_active'  => true,
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
        ]);
    }
}
