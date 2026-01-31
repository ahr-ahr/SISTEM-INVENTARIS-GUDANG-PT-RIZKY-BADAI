<?php

namespace App\Policies\Inventory;

use App\Models\User;
use App\Models\Inventory\Receiving;
use App\Enums\PermissionEnum;

class ReceivingPolicy
{
    public function create(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::BARANG_MASUK->value);
    }

    public function approve(User $user, Receiving $receiving): bool
    {
        return
            $user->hasPermission(PermissionEnum::APPROVE_STOK->value)
            && $receiving->status === 'PENDING'
            && $receiving->user_id !== $user->id;
    }

    public function reject(User $user, Receiving $receiving): bool
    {
        return
            $user->hasPermission(PermissionEnum::REJECT_STOK->value)
            && $receiving->status === 'PENDING'
            && $receiving->user_id !== $user->id;
    }
}
