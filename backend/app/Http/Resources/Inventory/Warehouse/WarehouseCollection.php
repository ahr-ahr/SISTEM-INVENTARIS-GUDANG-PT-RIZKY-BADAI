<?php

namespace App\Http\Resources\Inventory\Warehouse;

use App\Http\Resources\BaseApiCollection;

class WarehouseCollection extends BaseApiCollection
{
    protected function resourceClass(): string
    {
        return WarehouseResource::class;
    }
}
