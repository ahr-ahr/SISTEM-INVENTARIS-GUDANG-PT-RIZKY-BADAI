<?php

namespace App\Http\Requests\Inventory\QualityControl;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Inventory\QualityControl;
use App\Enums\PermissionEnum;

class StoreQualityControlRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasPermission(
            PermissionEnum::BARANG_MASUK->value
        ) ?? false;
    }

    public function rules(): array
    {
        return [
            'receiving_id' => 'required|exists:receivings,id',
        ];
    }
}
