<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Enums\PermissionEnum;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $perms = fn (array $enums) => Permission::whereIn(
            'name',
            array_map(fn (PermissionEnum $e) => $e->value, $enums)
        )->pluck('id')->toArray();

        $superAdmin = Role::where('name', 'super_admin')->first();
        $admin      = Role::where('name', 'admin')->first();
        $kepala     = Role::where('name', 'kepala_gudang')->first();
        $staff      = Role::where('name', 'staff_gudang')->first();
        $qc         = Role::where('name', 'petugas_qc')->first();
        $bongkar    = Role::where('name', 'petugas_bongkar_muat')->first();
        $scm        = Role::where('name', 'supply_chain_supervisor')->first();
        $timbang    = Role::where('name', 'petugas_rekap_timbang')->first();

        // SUPER ADMIN → ALL
        $superAdmin?->permissions()->sync(Permission::pluck('id')->toArray());

        // ADMIN
        $admin?->permissions()->sync($perms([
            PermissionEnum::MANAGE_USERS,
            PermissionEnum::MANAGE_ROLES,
            PermissionEnum::MANAGE_PERMISSIONS,

            PermissionEnum::VIEW_BARANG,
            PermissionEnum::CREATE_BARANG,
            PermissionEnum::UPDATE_BARANG,
            PermissionEnum::DELETE_BARANG,

            PermissionEnum::BARANG_MASUK,
            PermissionEnum::BARANG_KELUAR,
            PermissionEnum::ADJUST_STOK,
            PermissionEnum::APPROVE_STOK,
            PermissionEnum::REJECT_STOK,

            PermissionEnum::CREATE_TRANSFER,
            PermissionEnum::APPROVE_TRANSFER,
            PermissionEnum::REJECT_TRANSFER,
            PermissionEnum::VIEW_TRANSFER,

            PermissionEnum::VIEW_STOK,
            PermissionEnum::VIEW_LAPORAN,
        ]));

        // KEPALA GUDANG
        $kepala?->permissions()->sync($perms([
            PermissionEnum::VIEW_BARANG,
            PermissionEnum::VIEW_STOK,
            PermissionEnum::APPROVE_STOK,
            PermissionEnum::APPROVE_TRANSFER,
            PermissionEnum::VIEW_TRANSFER,
            PermissionEnum::VIEW_LAPORAN,
        ]));

        // STAFF GUDANG
        $staff?->permissions()->sync($perms([
            PermissionEnum::VIEW_BARANG,
            PermissionEnum::VIEW_STOK,
            PermissionEnum::BARANG_MASUK,
            PermissionEnum::BARANG_KELUAR,
            PermissionEnum::CREATE_TRANSFER,
            PermissionEnum::VIEW_TRANSFER,
        ]));

        // PETUGAS QC
        $qc?->permissions()->sync($perms([
            PermissionEnum::VIEW_BARANG,
            PermissionEnum::VIEW_STOK,
            PermissionEnum::QC_CHECK,
            PermissionEnum::VIEW_QC_REPORT,
            PermissionEnum::DECIDE_QC_REJECT,
        ]));

        // PETUGAS BONGKAR MUAT (RECEIVING)
        $bongkar?->permissions()->sync($perms([
            PermissionEnum::VIEW_BARANG,
            PermissionEnum::RECEIVING_CONFIRM_UNLOADED,
            PermissionEnum::RECEIVING_MARK_STAGED,
        ]));

        // SUPPLY CHAIN SUPERVISOR
        $scm?->permissions()->sync($perms([
            PermissionEnum::VIEW_BARANG,
            PermissionEnum::VIEW_STOK,
            PermissionEnum::APPROVE_STOK,
            PermissionEnum::APPROVE_TRANSFER,
            PermissionEnum::VIEW_QC_REPORT,
            PermissionEnum::VIEW_LAPORAN,
        ]));

        // PETUGAS REKAP TIMBANG
        $timbang?->permissions()->sync($perms([
            PermissionEnum::VIEW_BARANG,
            PermissionEnum::REKAP_TIMBANG,
        ]));
    }
}
