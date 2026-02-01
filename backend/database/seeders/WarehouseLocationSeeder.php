<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory\Warehouses\Warehouse;
use App\Models\Inventory\Warehouses\WarehouseLocation;

class WarehouseLocationSeeder extends Seeder
{
    public function run(): void
    {
        WarehouseLocation::query()->delete();

        $warehouseUtama = Warehouse::where('nama', 'Gudang Utama')->firstOrFail();

        // LEVEL 1 - AREA
        $areaA = WarehouseLocation::create([
            'warehouse_id' => $warehouseUtama->id,
            'parent_id'    => null,
            'nama'         => 'Area A',
            'level'        => 1,
            'is_active'    => true,
        ]);

        $areaB = WarehouseLocation::create([
            'warehouse_id' => $warehouseUtama->id,
            'parent_id'    => null,
            'nama'         => 'Area B',
            'level'        => 1,
            'is_active'    => true,
        ]);

        // LEVEL 2 - RAK
        WarehouseLocation::insert([
            [
                'warehouse_id' => $warehouseUtama->id,
                'parent_id'    => $areaA->id,
                'nama'         => 'Rak A1',
                'level'        => 2,
                'is_active'    => true,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'warehouse_id' => $warehouseUtama->id,
                'parent_id'    => $areaA->id,
                'nama'         => 'Rak A2',
                'level'        => 2,
                'is_active'    => true,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'warehouse_id' => $warehouseUtama->id,
                'parent_id'    => $areaB->id,
                'nama'         => 'Rak B1',
                'level'        => 2,
                'is_active'    => true,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}
