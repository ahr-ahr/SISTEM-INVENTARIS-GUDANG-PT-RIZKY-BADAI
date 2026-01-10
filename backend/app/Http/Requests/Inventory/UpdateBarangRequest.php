<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Inventory\Barang;

class UpdateBarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        $barang = $this->route('barang');

        return $this->user()->can('update', $barang);
    }

    public function rules(): array
    {
        return [
            'nama'         => 'sometimes|required|string',
            'kategori'     => 'nullable|string',
            'satuan'       => 'sometimes|required|string',
            'stok_minimum' => 'nullable|integer|min:0',
            'deskripsi'    => 'nullable|string',
            'is_active'    => 'boolean',
        ];
    }
}
