<?php

namespace App\Http\Requests\Inventory\QualityControl;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PermissionEnum;

class ApproveQualityControlRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasPermission(
            PermissionEnum::QC_CHECK->value
        ) ?? false;
    }

    public function rules(): array
    {
        return [
            'qty_accepted' => 'required|integer|min:0',
            'qty_rejected' => 'required|integer|min:0',
        ];
    }
}
