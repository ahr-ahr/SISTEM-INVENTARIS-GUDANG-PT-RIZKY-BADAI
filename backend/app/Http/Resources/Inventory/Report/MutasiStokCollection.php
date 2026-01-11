<?php

namespace App\Http\Resources\Inventory\Report;

use App\Http\Resources\BaseApiCollection;

class MutasiStokCollection extends BaseApiCollection
{
    protected function resourceClass(): string
    {
        return MutasiStokResource::class;
    }
}
