<?php

namespace App\Policies\Inventory;

use App\Models\User;
use App\Enums\PermissionEnum;

class ReceivingPolicy
{
    public function create(User $user): bool
    {
        return $user->hasPermission(
            PermissionEnum::BARANG_MASUK->value
        );
    }
}
