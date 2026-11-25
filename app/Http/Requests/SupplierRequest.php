<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:150', Rule::unique('suppliers', 'name')->ignore($this->supplier)],
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
        ];
    }
}
