<?php

namespace App\Http\Requests;

use App\Models\CartItem;
use Illuminate\Foundation\Http\FormRequest;

class CartStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', CartItem::class);
    }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Produk wajib dipilih.',
            'product_id.exists' => 'Produk tidak ditemukan.',
            'quantity.required' => 'Jumlah wajib diisi.',
            'quantity.integer' => 'Jumlah harus berupa angka.',
            'quantity.min' => 'Jumlah minimal 1.',
        ];
    }
}
