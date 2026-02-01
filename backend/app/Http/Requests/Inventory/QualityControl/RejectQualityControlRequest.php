<?php

namespace App\Http\Requests\Inventory\QualityControl;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PermissionEnum;

class RejectQualityControlRequest extends FormRequest
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
            'alasan' => 'required|string|max:255',
        ];
    }
}
