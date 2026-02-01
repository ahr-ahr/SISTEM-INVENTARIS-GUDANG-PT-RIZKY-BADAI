<?php

namespace App\Http\Requests\Inventory\WarehouseLocation;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Inventory\Warehouses\WarehouseLocation;

class UpdateWarehouseLocationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can(
            'update',
            $this->route('warehouseLocation')
        ) ?? false;
    }

    public function rules(): array
    {
        return [
            'nama'      => 'sometimes|required|string|max:150',
            'level'     => 'sometimes|required|in:ZONE,RACK,BIN',
            'is_active' => 'boolean',
        ];
    }
}
