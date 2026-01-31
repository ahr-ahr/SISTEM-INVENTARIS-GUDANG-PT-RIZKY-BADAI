<?php

namespace App\Http\Requests\Inventory\Adjustment;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Inventory\StockAdjustment;

class StockAdjustmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('create', StockAdjustment::class) ?? false;
    }

    public function rules(): array
    {
        return [
            'barang_id'   => 'required|exists:barangs,id',
            'stok_fisik'  => 'required|integer|min:0',
            'alasan'      => 'required|string|min:10|max:255',
        ];
    }
}
