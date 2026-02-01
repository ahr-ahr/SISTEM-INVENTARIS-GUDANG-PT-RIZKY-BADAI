<?php

namespace App\Policies\Inventory;

use App\Models\User;
use App\Models\Inventory\Warehouses\Warehouse;
use App\Enums\PermissionEnum;

class WarehousePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::VIEW_BARANG->value);
    }

    public function view(User $user, Warehouse $warehouse): bool
    {
        return $user->hasPermission(PermissionEnum::VIEW_BARANG->value);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::MANAGE_SYSTEM->value);
    }

    public function update(User $user, Warehouse $warehouse): bool
    {
        return $user->hasPermission(PermissionEnum::MANAGE_SYSTEM->value);
    }

    public function delete(User $user, Warehouse $warehouse): bool
    {
        return $user->hasPermission(PermissionEnum::MANAGE_SYSTEM->value);
    }
}
