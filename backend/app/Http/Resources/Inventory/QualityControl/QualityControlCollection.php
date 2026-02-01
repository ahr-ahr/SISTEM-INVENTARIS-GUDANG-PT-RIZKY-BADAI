<?php

namespace App\Http\Resources\Inventory\QualityControl;

use App\Http\Resources\BaseApiCollection;

class QualityControlCollection extends BaseApiCollection
{
    protected function resourceClass(): string
    {
        return QualityControlResource::class;
    }
}
