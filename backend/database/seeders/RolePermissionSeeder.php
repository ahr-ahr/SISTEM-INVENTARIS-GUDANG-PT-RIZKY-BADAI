<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil role
        $superAdmin = Role::where('name', 'super_admin')->first();
        $admin      = Role::where('name', 'admin')->first();
        $kepala     = Role::where('name', 'kepala_gudang')->first();
        $staff      = Role::where('name', 'staff_gudang')->first();
        $qc         = Role::where('name', 'petugas_qc')->first();
        $bongkar    = Role::where('name', 'petugas_bongkar_muat')->first();
        $scm        = Role::where('name', 'supply_chain_supervisor')->first();
        $timbang    = Role::where('name', 'petugas_rekap_timbang')->first();

        // Ambil semua permission (untuk super admin)
        $allPermissions = Permission::pluck('id')->toArray();

        /*
        |--------------------------------------------------------------------------
        | SUPER ADMIN (DEV)
        |--------------------------------------------------------------------------
        */
        $superAdmin?->permissions()->sync($allPermissions);

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */
        $admin?->permissions()->sync(
            Permission::whereIn('name', [
                'view_barang',
                'create_barang',
                'update_barang',
                'delete_barang',
                'barang_masuk',
                'barang_keluar',
                'approve_stok',
                'view_laporan',
            ])->pluck('id')->toArray()
        );

        /*
        |--------------------------------------------------------------------------
        | KEPALA GUDANG
        |--------------------------------------------------------------------------
        */
        $kepala?->permissions()->sync(
            Permission::whereIn('name', [
                'view_barang',
                'approve_stok',
                'view_laporan',
            ])->pluck('id')->toArray()
        );

        /*
        |--------------------------------------------------------------------------
        | STAFF GUDANG
        |--------------------------------------------------------------------------
        */
        $staff?->permissions()->sync(
            Permission::whereIn('name', [
                'view_barang',
                'barang_masuk',
                'barang_keluar',
            ])->pluck('id')->toArray()
        );

        /*
        |--------------------------------------------------------------------------
        | PETUGAS QC
        |--------------------------------------------------------------------------
        */
        $qc?->permissions()->sync(
            Permission::whereIn('name', [
                'view_barang',
                'qc_check',
            ])->pluck('id')->toArray()
        );

        /*
        |--------------------------------------------------------------------------
        | PETUGAS BONGKAR MUAT
        |--------------------------------------------------------------------------
        */
        $bongkar?->permissions()->sync(
            Permission::whereIn('name', [
                'view_barang',
            ])->pluck('id')->toArray()
        );

        /*
        |--------------------------------------------------------------------------
        | SUPPLY CHAIN SUPERVISOR
        |--------------------------------------------------------------------------
        */
        $scm?->permissions()->sync(
            Permission::whereIn('name', [
                'view_barang',
                'approve_stok',
                'view_laporan',
            ])->pluck('id')->toArray()
        );

        /*
        |--------------------------------------------------------------------------
        | PETUGAS REKAP TIMBANG
        |--------------------------------------------------------------------------
        */
        $timbang?->permissions()->sync(
            Permission::whereIn('name', [
                'view_barang',
                'rekap_timbang',
            ])->pluck('id')->toArray()
        );
    }
}
