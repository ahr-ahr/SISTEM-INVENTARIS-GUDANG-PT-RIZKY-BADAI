<?php

namespace App\Http\Requests\Inventory\Receiving;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Inventory\Receiving;

class RejectReceivingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can(
            'reject',
            $this->route('receiving')
        ) ?? false;
    }

    public function rules(): array
    {
        return [
            'alasan' => 'required|string|min:10|max:255',
        ];
    }
}

?>