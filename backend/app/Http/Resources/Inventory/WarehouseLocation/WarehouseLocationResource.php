<?php

namespace App\Http\Resources\Inventory\WarehouseLocation;

use App\Http\Resources\BaseApiResource;

class WarehouseLocationResource extends BaseApiResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->int($this->id),
            'warehouse_id'=> $this->int($this->warehouse_id),
            'parent_id'   => $this->int($this->parent_id),
            'nama'        => $this->nama,
            'level'       => $this->level,
            'is_active'   => (bool) $this->is_active,
            'children'    => WarehouseLocationResource::collection(
                $this->whenLoaded('children')
            ),
        ];
    }
}
