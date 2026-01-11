<?php

namespace App\Http\Requests\Inventory\Category;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Inventory\Category;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('category'));
    }

    public function rules(): array
    {
        return [
            'nama'       => 'required|string|max:100',
            'deskripsi'  => 'nullable|string',
            'is_active'  => 'boolean',
        ];
    }
}
