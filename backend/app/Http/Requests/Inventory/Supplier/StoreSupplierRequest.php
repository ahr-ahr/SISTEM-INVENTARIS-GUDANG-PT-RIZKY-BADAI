<?php

namespace App\Http\Requests\Inventory\Supplier;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Inventory\Supplier;

class StoreSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Supplier::class);
    }

    public function rules(): array
    {
        return [
            'kode'     => 'required|string|max:50|unique:suppliers,kode',
            'nama'     => 'required|string|max:150',
            'telepon'  => 'nullable|string|max:50',
            'email'    => 'nullable|email',
            'alamat'   => 'nullable|string',
        ];
    }
}
