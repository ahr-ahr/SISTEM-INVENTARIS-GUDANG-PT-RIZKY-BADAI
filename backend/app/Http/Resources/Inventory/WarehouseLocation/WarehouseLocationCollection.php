<?php

namespace App\Http\Resources\Inventory\WarehouseLocation;

use App\Http\Resources\BaseApiCollection;

class WarehouseLocationCollection extends BaseApiCollection
{
    protected function resourceClass(): string
    {
        return WarehouseLocationResource::class;
    }
}
