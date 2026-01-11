<?php

namespace App\Policies\Inventory;

use App\Models\User;
use App\Enums\PermissionEnum;

class PengeluaranPolicy
{
    public function create(User $user): bool
    {
        return $user->hasPermission(
            PermissionEnum::BARANG_KELUAR->value
        );
    }
}

?>