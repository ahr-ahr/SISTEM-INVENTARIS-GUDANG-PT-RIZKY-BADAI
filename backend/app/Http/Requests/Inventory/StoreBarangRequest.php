<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Inventory\Barang;

class StoreBarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Barang::class);
    }

    public function rules(): array
    {
        return [
            'kode'         => 'required|string|unique:barangs,kode',
            'nama'         => 'required|string',
            'category_id'     => 'nullable|string:exists:categories,id',
            'satuan'       => 'required|string',
            'stok_minimum' => 'nullable|integer|min:0',
            'deskripsi'    => 'nullable|string',
        ];
    }
}
