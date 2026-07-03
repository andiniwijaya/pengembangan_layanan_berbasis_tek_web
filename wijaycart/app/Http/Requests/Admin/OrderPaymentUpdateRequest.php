<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class OrderPaymentUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('updatePayment', $this->route('order'));
    }

    public function rules(): array
    {
        return [
            'status' => ['required', 'in:pending,paid,failed,refunded'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Status pembayaran wajib dipilih.',
            'status.in' => 'Status pembayaran tidak valid.',
        ];
    }
}
