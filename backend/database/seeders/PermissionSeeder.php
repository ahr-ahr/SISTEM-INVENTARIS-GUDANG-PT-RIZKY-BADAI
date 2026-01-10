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

            // Master Barang
            ['name' => 'view_barang', 'label' => 'Lihat Barang'],
            ['name' => 'create_barang', 'label' => 'Tambah Barang'],
            ['name' => 'update_barang', 'label' => 'Edit Barang'],
            ['name' => 'delete_barang', 'label' => 'Hapus Barang'],

            // Stok & Gudang
            ['name' => 'barang_masuk', 'label' => 'Barang Masuk'],
            ['name' => 'barang_keluar', 'label' => 'Barang Keluar'],
            ['name' => 'approve_stok', 'label' => 'Approve Stok'],

            // Timbang & QC
            ['name' => 'rekap_timbang', 'label' => 'Rekap Timbang'],
            ['name' => 'qc_check', 'label' => 'Quality Control'],

            // Laporan
            ['name' => 'view_laporan', 'label' => 'Lihat Laporan'],
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