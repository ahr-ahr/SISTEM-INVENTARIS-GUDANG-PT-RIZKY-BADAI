<?php

namespace App\Http\Resources\Inventory\Dispatch;

use App\Http\Resources\BaseApiCollection;

class DispatchCollection extends BaseApiCollection
{
    protected function resourceClass(): string
    {
        return DispatchResource::class;
    }
}
