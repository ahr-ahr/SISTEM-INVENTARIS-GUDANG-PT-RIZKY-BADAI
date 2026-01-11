<?php

namespace App\Http\Resources\Inventory\Category;

use App\Http\Resources\BaseApiCollection;

class CategoryCollection extends BaseApiCollection
{
    protected function resourceClass(): string
    {
        return CategoryResource::class;
    }
}
