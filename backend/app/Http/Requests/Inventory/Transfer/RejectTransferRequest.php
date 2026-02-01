<?php

namespace App\Http\Requests\Inventory\Transfer;

use Illuminate\Foundation\Http\FormRequest;

class RejectTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can(
            'reject',
            $this->route('transfer')
        );
    }

    public function rules(): array
    {
        return [
            'alasan' => 'required|string|min:10|max:255',
        ];
    }
}
