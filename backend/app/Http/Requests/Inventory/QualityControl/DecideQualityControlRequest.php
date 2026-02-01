<?php

namespace App\Http\Requests\Inventory\QualityControl;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PermissionEnum;

class DecideQualityControlRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasPermission(
            PermissionEnum::DECIDE_QC_REJECT->value
        ) ?? false;
    }

    public function rules(): array
    {
        return [
            'decision' => 'required|in:RETURN_TO_SUPPLIER,DISPOSED,REWORK',
            'note'     => 'nullable|string|max:255',
        ];
    }
}
