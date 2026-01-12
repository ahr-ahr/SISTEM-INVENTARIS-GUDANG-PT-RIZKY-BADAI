<?php

namespace App\Http\Resources\Inventory\Supplier;

use App\Http\Resources\BaseApiCollection;

class SupplierCollection extends BaseApiCollection
{
    protected function resourceClass(): string
    {
        return SupplierResource::class;
    }
}
