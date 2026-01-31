<?php

namespace App\Http\Requests\Inventory\Adjustment;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Inventory\StockAdjustment;

class RejectStockAdjustmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can(
            'reject',
            $this->route('adjustment')
        ) ?? false;
    }

    public function rules(): array
    {
        return [
            'alasan' => 'required|string|min:10|max:255',
        ];
    }
}
