<?php

namespace App\Policies\Inventory;

use App\Models\User;
use App\Enums\PermissionEnum;

class StockAdjustmentPolicy
{
    public function create(User $user): bool
    {
        return $user->hasPermission(
            PermissionEnum::APPROVE_STOK->value
        );
    }
}
