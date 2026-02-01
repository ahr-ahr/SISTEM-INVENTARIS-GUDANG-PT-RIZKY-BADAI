<?php

namespace App\Http\Resources\Inventory\Receiving;

use App\Http\Resources\BaseApiCollection;

class ReceivingCollection extends BaseApiCollection
{
    protected function resourceClass(): string
    {
        return ReceivingResource::class;
    }
}
