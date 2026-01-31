<?php

namespace App\Policies\Inventory;

use App\Models\User;
use App\Models\Inventory\StockAdjustment;
use App\Enums\PermissionEnum;

class StockAdjustmentPolicy
{
    public function create(User $user): bool
    {
        return $user->hasPermission(
            PermissionEnum::ADJUST_STOK->value
        );
    }

    public function approve(User $user, StockAdjustment $adjustment): bool
    {
        return
            $user->hasPermission(PermissionEnum::APPROVE_STOK->value)
            && $adjustment->status === 'PENDING';
    }

    public function reject(User $user, StockAdjustment $adjustment): bool
    {
        return
            $user->hasPermission(PermissionEnum::REJECT_STOK->value)
            && $adjustment->status === 'PENDING';
    }
}
