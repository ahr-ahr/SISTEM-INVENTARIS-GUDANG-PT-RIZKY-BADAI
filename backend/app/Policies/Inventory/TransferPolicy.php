<?php

namespace App\Policies\Inventory;

use App\Models\User;
use App\Models\Inventory\Transfer;
use App\Enums\PermissionEnum;

class TransferPolicy
{
    public function create(User $user): bool
    {
        return $user->hasPermission(
            PermissionEnum::CREATE_TRANSFER->value
        );
    }

    public function approve(User $user, Transfer $transfer): bool
    {
        return
            $user->hasPermission(PermissionEnum::APPROVE_STOK->value)
            && $transfer->status === 'PENDING'
            && $transfer->requested_by !== $user->id;
    }

    public function reject(User $user, Transfer $transfer): bool
    {
        return
            $user->hasPermission(PermissionEnum::REJECT_STOK->value)
            && $transfer->status === 'PENDING'
            && $transfer->requested_by !== $user->id;
    }
}
