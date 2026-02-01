<?php

namespace App\Policies\Inventory;

use App\Models\User;
use App\Models\Inventory\QualityControl;
use App\Enums\PermissionEnum;

class QualityControlPolicy
{
    /* =====================
     | VIEW
     |=====================*/
    public function viewAny(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::VIEW_STOK->value);
    }

    public function view(User $user, QualityControl $qc): bool
    {
        return $user->hasPermission(PermissionEnum::VIEW_STOK->value);
    }

    /* =====================
     | CREATE
     |=====================*/
    public function create(User $user): bool
    {
        return $user->hasPermission(PermissionEnum::BARANG_MASUK->value);
    }

    /* =====================
     | APPROVE
     |=====================*/
    public function approve(User $user, QualityControl $qc): bool
    {
        if (!$user->hasPermission(PermissionEnum::QC_CHECK->value)) {
            return false;
        }

        if ($qc->status !== 'PENDING') {
            return false;
        }

        // optional: tidak boleh approve QC sendiri
        if ($qc->requested_by === $user->id) {
            return false;
        }

        return true;
    }

    /* =====================
     | REJECT
     |=====================*/
    public function reject(User $user, QualityControl $qc): bool
    {
        if (!$user->hasPermission(PermissionEnum::QC_CHECK->value)) {
            return false;
        }

        if ($qc->status !== 'PENDING') {
            return false;
        }

        if ($qc->requested_by === $user->id) {
            return false;
        }

        return true;
    }
}
