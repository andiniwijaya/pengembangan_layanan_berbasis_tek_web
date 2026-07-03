<?php

namespace App\Http\Requests\Admin;

use App\Models\Setting;
use Illuminate\Foundation\Http\FormRequest;

class SettingUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', Setting::class);
    }

    public function rules(): array
    {
        return [
            'store_name' => ['required', 'string', 'max:255'],
            'store_email' => ['required', 'email'],
            'store_phone' => ['nullable', 'string'],
            'store_address' => ['nullable', 'string'],
            'store_description' => ['nullable', 'string'],
            'shipping_cost' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'store_name.required' => 'Nama toko wajib diisi.',
            'store_email.required' => 'Email toko wajib diisi.',
            'store_email.email' => 'Format email tidak valid.',
            'shipping_cost.required' => 'Biaya pengiriman wajib diisi.',
            'shipping_cost.numeric' => 'Biaya pengiriman harus berupa angka.',
            'shipping_cost.min' => 'Biaya pengiriman tidak boleh negatif.',
        ];
    }
}
