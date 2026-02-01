<?php

namespace App\Http\Requests\Inventory\Receiving;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Inventory\Receiving;

class StoreReceivingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Receiving::class);
    }

    public function rules(): array
    {
        return [
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'location_id'  => 'required|exists:warehouse_locations,id',
            'barang_id'   => 'required|exists:barangs,id',
            'jumlah'      => 'required|integer|min:1',
            'keterangan'  => 'nullable|string|max:255',
        ];
    }
}
