<?php

namespace App\Http\Resources\Inventory\Warehouse;

use App\Http\Resources\BaseApiCollection;

class WarehouseStockCollection extends BaseApiCollection
{
    protected function resourceClass(): string
    {
        return WarehouseStockResource::class;
    }
}
