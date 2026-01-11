<?php

namespace App\Http\Requests\Inventory\Supplier;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('supplier'));
    }

    public function rules(): array
    {
        return [
            'nama'     => 'required|string|max:150',
            'telepon'  => 'nullable|string|max:50',
            'email'    => 'nullable|email',
            'alamat'   => 'nullable|string',
            'is_active'=> 'boolean',
        ];
    }
}
