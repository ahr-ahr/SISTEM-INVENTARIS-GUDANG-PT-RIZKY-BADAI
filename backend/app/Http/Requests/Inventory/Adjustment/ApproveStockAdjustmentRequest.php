<?php

namespace App\Http\Requests\Inventory\Adjustment;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Inventory\StockAdjustment;

class ApproveStockAdjustmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can(
            'approve',
            $this->route('adjustment')
        ) ?? false;
    }

    public function rules(): array
    {
        return [];
    }
}
