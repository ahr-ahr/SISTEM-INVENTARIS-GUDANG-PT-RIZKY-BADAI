<?php

namespace App\Http\Requests\Inventory\WarehouseStock;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Inventory\Warehouses\WarehouseStock;

class MarkDamagedWarehouseStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('markDamaged', WarehouseStock::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'warehouse_id' => 'required|exists:warehouses,id',
            'location_id'  => 'required|exists:warehouse_locations,id',
            'barang_id'    => 'required|exists:barangs,id',
            'jumlah'       => 'required|integer|min:1',
        ];
    }
}
