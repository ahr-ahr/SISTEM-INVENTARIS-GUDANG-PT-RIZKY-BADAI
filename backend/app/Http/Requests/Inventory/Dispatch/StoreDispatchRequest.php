<?php

namespace App\Http\Requests\Inventory\Dispatch;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PermissionEnum;

class StoreDispatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasPermission(
            PermissionEnum::BARANG_KELUAR->value
        ) ?? false;
    }

    public function rules(): array
    {
        return [
            'barang_id'  => 'required|exists:barangs,id',
            'jumlah'     => 'required|integer|min:1',
            'tujuan'     => 'required|string|max:150',
            'keterangan' => 'nullable|string|max:255',
        ];
    }
}

?>