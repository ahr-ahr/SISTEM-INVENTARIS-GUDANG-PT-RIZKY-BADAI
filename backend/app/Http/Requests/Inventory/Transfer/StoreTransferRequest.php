<?php

namespace App\Http\Requests\Inventory\Transfer;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Inventory\Transfer;

class StoreTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Transfer::class);
    }

    public function rules(): array
    {
        return [
            'warehouse_id' => 'required|exists:warehouses,id',
            'barang_id'        => 'required|exists:barangs,id',
            'from_location_id' => 'required|integer',
            'to_location_id'   => 'required|integer|different:from_location_id',
            'jumlah'           => 'required|integer|min:1',
            'alasan'           => 'nullable|string|max:255',
        ];
    }
}
