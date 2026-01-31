<?php

namespace App\Http\Requests\Inventory\Dispatch;

use Illuminate\Foundation\Http\FormRequest;

class RejectDispatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can(
            'reject',
            $this->route('dispatch')
        ) ?? false;
    }

    public function rules(): array
    {
        return [
            'alasan' => 'required|string|min:10|max:255',
        ];
    }
}
