<?php

namespace App\Http\Resources\Inventory\Alert;

use App\Http\Resources\BaseApiCollection;

class StokMinimumCollection extends BaseApiCollection
{
    protected function resourceClass(): string
    {
        return StokMinimumResource::class;
    }
}
