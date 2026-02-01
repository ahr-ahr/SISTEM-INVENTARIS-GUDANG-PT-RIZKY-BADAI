<?php

namespace App\Http\Requests\Inventory\WarehouseLocation;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Inventory\WarehouseLocation;

class StoreWarehouseLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', WarehouseLocation::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'warehouse_id' => 'required|exists:warehouses,id',
            'parent_id'    => 'nullable|exists:warehouse_locations,id',
            'nama'         => 'required|string|max:150',
            'level'        => 'required|in:ZONE,RACK,BIN',
            'is_active'    => 'boolean',
        ];
    }
}
