<?php

namespace App\Http\Resources\Inventory;

use App\Http\Resources\BaseApiCollection;

class BarangCollection extends BaseApiCollection
{
    protected function resourceClass(): string
    {
        return BarangResource::class;
    }
}
