<?php

namespace App\Http\Requests\Inventory\Warehouse;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Inventory\Warehouse;

class UpdateWarehouseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('warehouse')) ?? false;
    }

    public function rules(): array
    {
        return [
            'nama'      => 'sometimes|required|string|max:150',
            'tipe'      => 'sometimes|required|in:MAIN,PRODUCTION,QC,VIRTUAL',
            'alamat'    => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ];
    }
}
