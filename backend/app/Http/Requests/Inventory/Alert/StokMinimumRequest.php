<?php

namespace App\Http\Requests\Inventory\Alert;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PermissionEnum;

class StokMinimumRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasPermission(
            PermissionEnum::VIEW_LAPORAN->value
        ) ?? false;
    }

    public function rules(): array
    {
        return [
            'per_page' => 'nullable|integer|min:1|max:100',
        ];
    }
}
