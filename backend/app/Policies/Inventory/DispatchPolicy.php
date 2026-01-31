<?php

namespace App\Policies\Inventory;

use App\Models\User;
use App\Models\Inventory\Dispatch;
use App\Enums\PermissionEnum;

class DispatchPolicy
{
    public function create(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::BARANG_KELUAR->value);
    }

    public function approve(User $user, Dispatch $dispatch): bool
    {
        return
            $user->hasPermission(PermissionEnum::APPROVE_STOK->value)
            && $dispatch->status === 'PENDING'
            && $dispatch->requested_by !== $user->id;
    }

    public function reject(User $user, Dispatch $dispatch): bool
    {
        return
            $user->hasPermission(PermissionEnum::REJECT_STOK->value)
            && $dispatch->status === 'PENDING'
            && $dispatch->requested_by !== $user->id;
    }
}
