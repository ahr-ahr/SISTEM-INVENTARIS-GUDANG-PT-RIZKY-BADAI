<?php

namespace App\Policies\Inventory;

use App\Models\User;
use App\Models\Inventory\Supplier;
use App\Enums\PermissionEnum;

class SupplierPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::VIEW_BARANG->value);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::CREATE_BARANG->value);
    }

    public function update(User $user, Supplier $supplier): bool
    {
        return $user->hasPermission(PermissionEnum::UPDATE_BARANG->value);
    }

    public function delete(User $user, Supplier $supplier): bool
    {
        return $user->hasPermission(PermissionEnum::DELETE_BARANG->value);
    }
}
