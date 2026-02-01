<?php

namespace App\Http\Resources\Inventory\WarehouseStock;

use App\Http\Resources\BaseApiCollection;

class WarehouseStockCollection extends BaseApiCollection
{
    protected function resourceClass(): string
    {
        return WarehouseStockResource::class;
    }
}
