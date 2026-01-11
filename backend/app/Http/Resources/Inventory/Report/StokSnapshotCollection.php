<?php

namespace App\Http\Resources\Inventory\Report;

use App\Http\Resources\BaseApiCollection;

class StokSnapshotCollection extends BaseApiCollection
{
    protected function resourceClass(): string
    {
        return StokSnapshotResource::class;
    }
}
