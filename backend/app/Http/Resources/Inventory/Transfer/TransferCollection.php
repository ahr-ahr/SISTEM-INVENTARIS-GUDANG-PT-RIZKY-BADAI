<?php

namespace App\Http\Resources\Inventory\Transfer;

use App\Http\Resources\BaseApiCollection;

class TransferCollection extends BaseApiCollection
{
    protected function resourceClass(): string
    {
        return TransferResource::class;
    }
}
