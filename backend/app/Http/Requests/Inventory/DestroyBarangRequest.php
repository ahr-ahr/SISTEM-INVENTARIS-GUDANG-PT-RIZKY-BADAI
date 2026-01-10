<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\BarangDeactivationReason;
use Illuminate\Validation\Rule;

class DestroyBarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        $barang = $this->route('barang');

        return $this->user()->can('delete', $barang);
    }

    public function rules(): array
    {
        return [
            'reason' => ['required', Rule::enum(BarangDeactivationReason::class)],
        ];
    }
}
