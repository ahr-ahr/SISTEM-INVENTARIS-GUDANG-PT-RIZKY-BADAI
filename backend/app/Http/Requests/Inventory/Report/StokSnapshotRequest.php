<?php

namespace App\Http\Requests\Inventory\Report;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PermissionEnum;

class StokSnapshotRequest extends FormRequest
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
            'keyword'   => 'nullable|string|max:100',
            'stok_min'  => 'nullable|integer|min:0',
            'stok_max'  => 'nullable|integer|min:0',
            'per_page'  => 'nullable|integer|min:1|max:100',
        ];
    }
}
