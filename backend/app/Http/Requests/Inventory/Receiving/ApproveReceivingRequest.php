<?php

namespace App\Http\Requests\Inventory\Receiving;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Inventory\Receiving;

class ApproveReceivingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can(
            'approve',
            $this->route('receiving')
        ) ?? false;
    }

    public function rules(): array
    {
        return [
        ];
    }
}
