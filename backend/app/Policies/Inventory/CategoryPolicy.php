<?php

namespace App\Policies\Inventory;

use App\Models\User;
use App\Enums\PermissionEnum;

class CategoryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::VIEW_BARANG->value);
    }

    public function create(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::CREATE_BARANG->value);
    }

    public function update(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::UPDATE_BARANG->value);
    }

    public function delete(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::DELETE_BARANG->value);
    }
}