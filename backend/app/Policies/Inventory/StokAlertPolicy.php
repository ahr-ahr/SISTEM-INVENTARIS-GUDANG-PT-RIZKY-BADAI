<?php

namespace App\Policies\Inventory;

use App\Models\User;
use App\Enums\PermissionEnum;

class StokAlertPolicy
{
    public function view(User $user): bool
    {
        return $user->hasPermission(
            PermissionEnum::VIEW_LAPORAN->value
        );
    }
}
