<?php

namespace App\Http\Requests;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', Order::class);
    }

    public function rules(): array
    {
        return [
            'shipping_name' => ['required', 'string', 'max:255'],
            'shipping_phone' => ['required', 'string', 'max:20'],
            'shipping_address' => ['required', 'string', 'max:500'],
            'payment_method' => ['required', 'in:bank_transfer,qris,cod'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function attributes(): array
    {
        return [
            'shipping_name' => 'nama penerima',
            'shipping_phone' => 'nomor telepon',
            'shipping_address' => 'alamat pengiriman',
            'payment_method' => 'metode pembayaran',
            'notes' => 'catatan',
        ];
    }

    public function messages(): array
    {
        return [
            'shipping_name.required' => 'Nama penerima wajib diisi.',
            'shipping_name.max' => 'Nama penerima maksimal 255 karakter.',
            'shipping_phone.required' => 'Nomor telepon wajib diisi.',
            'shipping_phone.max' => 'Nomor telepon maksimal 20 karakter.',
            'shipping_address.required' => 'Alamat pengiriman wajib diisi.',
            'shipping_address.max' => 'Alamat pengiriman maksimal 500 karakter.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
            'payment_method.in' => 'Metode pembayaran tidak valid.',
            'notes.max' => 'Catatan maksimal 500 karakter.',
        ];
    }
}
