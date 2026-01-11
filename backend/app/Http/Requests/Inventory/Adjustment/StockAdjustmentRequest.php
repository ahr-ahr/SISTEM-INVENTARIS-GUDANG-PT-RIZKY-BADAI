<?php

namespace App\Http\Requests\Inventory\Adjustment;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PermissionEnum;

class StockAdjustmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasPermission(
            PermissionEnum::APPROVE_STOK->value
        ) ?? false;
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
