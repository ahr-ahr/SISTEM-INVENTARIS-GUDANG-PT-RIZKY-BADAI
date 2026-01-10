<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/**
 * BaseApiCollection
 *
 * Fondasi untuk semua API Collection.
 * Fokus HANYA pada struktur data collection.
 */
abstract class BaseApiCollection extends ResourceCollection
{
    /**
     * Bungkus item collection dengan resource.
     */
    abstract protected function resourceClass(): string;

    public function toArray(Request $request): array
    {
        $resourceClass = $this->resourceClass();

        return [
            'items' => $resourceClass::collection($this->collection),
        ];
    }
}
