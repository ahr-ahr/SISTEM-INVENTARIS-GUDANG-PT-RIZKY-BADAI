<?php

namespace App\Http\Requests\Inventory\Receiving;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PermissionEnum;

class StorePenerimaanRequest extends FormRequest
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
            'barang_id'  => 'required|exists:barangs,id',
            'jumlah'     => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255',
        ];
    }
}
