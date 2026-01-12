<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Inventory\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        Supplier::truncate();

        Supplier::insert([
            [
                'kode'       => 'SUP-001',
                'nama'       => 'PT Sumber Besi Jaya',
                'telepon'    => '021-5551234',
                'email'      => 'info@sumberbesijaya.co.id',
                'alamat'     => 'Jl. Industri No. 10, Jakarta',
                'is_active'  => true,
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'kode'       => 'SUP-002',
                'nama'       => 'CV Cat Makmur',
                'telepon'    => '022-778899',
                'email'      => 'sales@catmakmur.co.id',
                'alamat'     => 'Jl. Raya Bandung No. 25, Bandung',
                'is_active'  => true,
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'kode'       => 'SUP-003',
                'nama'       => 'UD Aksesoris Bangunan',
                'telepon'    => '031-889977',
                'email'      => null,
                'alamat'     => 'Jl. Pahlawan No. 7, Surabaya',
                'is_active'  => true,
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
        ]);
    }
}
