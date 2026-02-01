<?php

namespace App\Policies\Inventory;

use App\Models\User;
use App\Models\Inventory\Warehouses\WarehouseLocation;
use App\Enums\PermissionEnum;

class WarehouseLocationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::VIEW_BARANG->value);
    }

    public function view(User $user, WarehouseLocation $location): bool
    {
        return $user->hasPermission(PermissionEnum::VIEW_BARANG->value);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::MANAGE_SYSTEM->value);
    }

    public function update(User $user, WarehouseLocation $location): bool
    {
        return $user->hasPermission(PermissionEnum::MANAGE_SYSTEM->value);
    }

    public function delete(User $user, WarehouseLocation $location): bool
    {
        return $user->hasPermission(PermissionEnum::MANAGE_SYSTEM->value);
    }
}
