<?php

namespace App\Enums;

enum PermissionEnum: string
{
    case INVENTORY_VIEW   = 'inventory.view';
    case INVENTORY_CREATE = 'inventory.create';
}
