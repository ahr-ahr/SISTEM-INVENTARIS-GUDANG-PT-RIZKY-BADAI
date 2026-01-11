<?php

namespace App\Http\Requests\Inventory\Report;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PermissionEnum;

class MutasiStokRequest extends FormRequest
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
            'barang_id'       => 'nullable|exists:barangs,id',
            'jenis'           => 'nullable|in:MASUK,KELUAR',
            'sumber'          => 'nullable|string|max:50',
            'tanggal_dari'    => 'nullable|date',
            'tanggal_sampai'  => 'nullable|date|after_or_equal:tanggal_dari',
            'per_page'        => 'nullable|integer|min:1|max:100',
        ];
    }
}
