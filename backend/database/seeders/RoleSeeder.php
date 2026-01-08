<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            [
                'name' => 'super_admin',
                'label' => 'Super Admin',
                'description' => 'Akses penuh ke sistem dan pengaturan website',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'admin',
                'label' => 'Admin',
                'description' => 'Admin operasional sistem',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'kepala_gudang',
                'label' => 'Kepala Gudang',
                'description' => 'Kepala gudang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'staff_gudang',
                'label' => 'Staff Gudang',
                'description' => 'Staff gudang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'petugas_qc',
                'label' => 'Petugas QC',
                'description' => 'Petugas quality control',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'petugas_bongkar_muat',
                'label' => 'Petugas Bongkar Muat',
                'description' => 'Petugas bongkar muat barang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'supply_chain_supervisor',
                'label' => 'Supply Chain Supervisor',
                'description' => 'Supervisor supply chain',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'petugas_rekap_timbang',
                'label' => 'Petugas Rekap Timbang',
                'description' => 'Petugas rekap timbang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
