<?php

namespace App\Http\Requests\Admin;

use App\Models\Supplier;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierRequest extends FormRequest
{
    public function authorize(): bool
    {
        $supplier = $this->route('supplier');

        if ($supplier) {
            return $this->user()->can('update', $supplier);
        }

        return $this->user()->can('create', Supplier::class);
    }

    public function rules(): array
    {
        $supplierId = $this->route('supplier')?->id;

        return [
            'code' => ['nullable', 'string', 'max:20', Rule::unique('suppliers', 'code')->ignore($supplierId)],
            'name' => ['required', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }

    public function attributes(): array
    {
        return [
            'code' => 'kode supplier',
            'name' => 'nama supplier',
            'contact_person' => 'contact person',
            'phone' => 'telepon',
            'email' => 'email',
            'address' => 'alamat',
            'notes' => 'catatan',
            'status' => 'status',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama supplier wajib diisi.',
            'name.max' => 'Nama supplier maksimal 255 karakter.',
            'code.unique' => 'Kode supplier sudah digunakan.',
            'email.email' => 'Format email tidak valid.',
            'status.required' => 'Status supplier wajib dipilih.',
            'status.in' => 'Status supplier tidak valid.',
        ];
    }
}
