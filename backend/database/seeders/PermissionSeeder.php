<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\PermissionEnum;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (PermissionEnum::cases() as $permission) {
            DB::table('permissions')->updateOrInsert(
                ['name' => $permission->value],
                [
                    'label' => $this->label($permission),
                    'description' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }

    protected function label(PermissionEnum $permission): string
    {
        return match ($permission) {
            PermissionEnum::MANAGE_SYSTEM      => 'Kelola Sistem',
            PermissionEnum::MANAGE_USERS       => 'Kelola User',
            PermissionEnum::MANAGE_ROLES       => 'Kelola Role',
            PermissionEnum::MANAGE_PERMISSIONS => 'Kelola Permission',

            PermissionEnum::VIEW_BARANG   => 'Lihat Barang',
            PermissionEnum::CREATE_BARANG => 'Tambah Barang',
            PermissionEnum::UPDATE_BARANG => 'Edit Barang',
            PermissionEnum::DELETE_BARANG => 'Hapus Barang',

            PermissionEnum::BARANG_MASUK   => 'Barang Masuk',
            PermissionEnum::BARANG_KELUAR  => 'Barang Keluar',
            PermissionEnum::ADJUST_STOK    => 'Adjust Stok',
            PermissionEnum::APPROVE_STOK   => 'Approve Stok',
            PermissionEnum::REJECT_STOK    => 'Reject Stok',
            PermissionEnum::TRANSFER_STOK  => 'Transfer Stok',
            PermissionEnum::VIEW_STOK      => 'Lihat Stok',

            PermissionEnum::REKAP_TIMBANG => 'Rekap Timbang',
            PermissionEnum::QC_CHECK     => 'Quality Control',

            PermissionEnum::VIEW_LAPORAN => 'Lihat Laporan',
        };
    }
}
