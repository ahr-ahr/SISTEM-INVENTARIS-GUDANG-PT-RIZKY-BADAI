<?php

namespace App\Http\Requests\Inventory\Warehouse;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Inventory\Warehouses\Warehouse;

class StoreWarehouseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', Warehouse::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'nama'      => 'required|string|max:150',
            'tipe'      => 'required|in:MAIN,PRODUCTION,QC,VIRTUAL',
            'alamat'    => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ];
    }
}
