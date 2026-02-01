<?php

namespace App\Http\Requests\Inventory\Warehouse;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Inventory\Warehouses\WarehouseStock;

class TransferWarehouseStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('transfer', WarehouseStock::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'warehouse_id'     => 'required|exists:warehouses,id',
            'from_location_id' => 'required|exists:warehouse_locations,id|different:to_location_id',
            'to_location_id'   => 'required|exists:warehouse_locations,id',
            'barang_id'        => 'required|exists:barangs,id',
            'jumlah'           => 'required|integer|min:1',
        ];
    }
}
