<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // System
            ['name' => 'manage_system', 'label' => 'Kelola Sistem'],
            ['name' => 'manage_users', 'label' => 'Kelola User'],
            ['name' => 'manage_roles', 'label' => 'Kelola Role'],
            ['name' => 'manage_permissions', 'label' => 'Kelola Permission'],

            // Gudang
            ['name' => 'input_barang', 'label' => 'Input Barang'],
            ['name' => 'edit_barang', 'label' => 'Edit Barang'],
            ['name' => 'hapus_barang', 'label' => 'Hapus Barang'],
            ['name' => 'approve_barang', 'label' => 'Approve Barang'],
            ['name' => 'lihat_laporan', 'label' => 'Lihat Laporan'],
            ['name' => 'rekap_timbang', 'label' => 'Rekap Timbang'],
        ];

        foreach ($permissions as $p) {
            DB::table('permissions')->insert([
                'name' => $p['name'],
                'label' => $p['label'],
                'description' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
