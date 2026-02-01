<?php

namespace App\Http\Requests\Inventory\Transfer;

use Illuminate\Foundation\Http\FormRequest;

class ApproveTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can(
            'approve',
            $this->route('transfer')
        );
    }

    public function rules(): array
    {
        return [];
    }
}
