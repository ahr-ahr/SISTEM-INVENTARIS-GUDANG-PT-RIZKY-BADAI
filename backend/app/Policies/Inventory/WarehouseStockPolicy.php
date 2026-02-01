<?php

namespace App\Policies\Inventory;

use App\Models\User;
use App\Models\Inventory\Warehouses\WarehouseStock;
use App\Enums\PermissionEnum;

class WarehouseStockPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission(
            PermissionEnum::VIEW_STOK->value
        );
    }
    
    public function increase(User $user): bool
    {
        return $user->hasPermission(
            PermissionEnum::BARANG_MASUK->value
        );
    }

    public function decrease(User $user): bool
    {
        return $user->hasPermission(
            PermissionEnum::BARANG_KELUAR->value
        );
    }

    public function reserve(User $user): bool
    {
        return $user->hasPermission(
            PermissionEnum::BARANG_KELUAR->value
        );
    }

    public function transfer(User $user): bool
    {
        return $user->hasPermission(
            PermissionEnum::TRANSFER_STOK->value
        );
    }

    public function markDamaged(User $user): bool
    {
        return $user->hasPermission(
            PermissionEnum::QC_CHECK->value
        );
    }
}
