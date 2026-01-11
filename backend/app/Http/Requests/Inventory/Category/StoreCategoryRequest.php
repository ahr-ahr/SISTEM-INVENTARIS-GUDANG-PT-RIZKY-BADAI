<?php

namespace App\Http\Requests\Inventory\Category;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Inventory\Category;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Category::class);
    }

    public function rules(): array
    {
        return [
            'kode'       => 'required|string|max:50|unique:categories,kode',
            'nama'       => 'required|string|max:100',
            'deskripsi'  => 'nullable|string',
        ];
    }
}
