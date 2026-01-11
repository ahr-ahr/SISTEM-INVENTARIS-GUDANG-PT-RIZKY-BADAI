<?php

namespace App\Http\Resources\Inventory\Stock;

use App\Http\Resources\BaseApiCollection;

class StokCollection extends BaseApiCollection
{
    protected function resourceClass(): string
    {
        return StokResource::class;
    }
}

?>