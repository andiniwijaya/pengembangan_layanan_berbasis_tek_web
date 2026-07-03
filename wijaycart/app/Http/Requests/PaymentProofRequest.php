<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentProofRequest extends FormRequest
{
    public function authorize(): bool
    {
        $order = $this->route('order');

        return $this->user()?->id === $order?->user_id;
    }

    public function rules(): array
    {
        return [
            'payment_proof' => ['required', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'payment_proof.required' => 'Bukti pembayaran wajib diunggah.',
            'payment_proof.image' => 'File harus berupa gambar.',
            'payment_proof.mimes' => 'Format file harus JPG, JPEG, atau PNG.',
            'payment_proof.max' => 'Ukuran file maksimal 2 MB.',
        ];
    }
}
