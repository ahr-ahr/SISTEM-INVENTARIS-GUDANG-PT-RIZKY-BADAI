<?php

namespace App\Http\Resources\Inventory\Adjustment;

use App\Http\Resources\BaseApiCollection;

class StockAdjustmentCollection extends BaseApiCollection
{
    protected function resourceClass(): string
    {
        return StockAdjustmentResource::class;
    }
}
