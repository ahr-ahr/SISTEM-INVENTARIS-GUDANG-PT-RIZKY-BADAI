<?php

namespace App\Http\Requests\Inventory\Dispatch;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Inventory\Dispatch;

class ApproveDispatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can(
            'approve',
            $this->route('dispatch')
        ) ?? false;
    }

    public function rules(): array
    {
        return [];
    }
}
