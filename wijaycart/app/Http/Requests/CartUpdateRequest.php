<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('cartItem'));
    }

    public function rules(): array
    {
        return [
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'quantity.required' => 'Jumlah wajib diisi.',
            'quantity.integer' => 'Jumlah harus berupa angka.',
            'quantity.min' => 'Jumlah minimal 1.',
        ];
    }
}
