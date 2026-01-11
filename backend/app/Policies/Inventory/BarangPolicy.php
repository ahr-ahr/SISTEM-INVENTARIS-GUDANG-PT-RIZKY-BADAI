<?php

namespace App\Policies\Inventory;

use App\Models\User;
use App\Models\Inventory\Barang;
use App\Enums\PermissionEnum;

class BarangPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->canDo(PermissionEnum::VIEW_BARANG->value);
    }

    public function view(User $user, Barang $barang): bool
    {
        return $user->canDo(PermissionEnum::VIEW_BARANG->value);
    }

    public function create(User $user): bool
    {
        return $user->canDo(PermissionEnum::CREATE_BARANG->value);
    }

    public function update(User $user, Barang $barang): bool
    {
        return $user->canDo(PermissionEnum::UPDATE_BARANG->value);
    }

    public function delete(User $user, Barang $barang): bool
    {

        return $user->canDo(PermissionEnum::DELETE_BARANG->value);
    }

    public function restore(User $user, Barang $barang): bool
    {
        return false;
    }

    public function forceDelete(User $user, Barang $barang): bool
    {
        return false;
    }
}
