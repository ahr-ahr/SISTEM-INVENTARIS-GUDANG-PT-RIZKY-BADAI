<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = DB::table('roles')->pluck('id', 'name');
        $permissions = DB::table('permissions')->pluck('id', 'name');

        // Super Admin = semua permission
        foreach ($permissions as $permissionId) {
            DB::table('role_permissions')->insert([
                'role_id' => $roles['super_admin'],
                'permission_id' => $permissionId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Admin
        $adminPermissions = [
            'input_barang',
            'edit_barang',
            'hapus_barang',
            'approve_barang',
            'lihat_laporan',
            'rekap_timbang',
        ];

        foreach ($adminPermissions as $p) {
            DB::table('role_permissions')->insert([
                'role_id' => $roles['admin'],
                'permission_id' => $permissions[$p],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Role lain bisa ditambah nanti
    }
}
