<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->user());
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$this->user()->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama',
            'email' => 'email',
            'phone' => 'nomor telepon',
            'address' => 'alamat',
            'password' => 'password',
            'avatar' => 'foto profil',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 255 karakter.',
            'email.unique' => 'Email sudah digunakan.',
            'phone.max' => 'Nomor telepon maksimal 20 karakter.',
            'address.max' => 'Alamat maksimal 500 karakter.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'avatar.image' => 'Foto profil harus berupa gambar.',
            'avatar.mimes' => 'Foto profil harus berformat JPEG, PNG, atau WebP.',
            'avatar.max' => 'Foto profil maksimal 2 MB.',
        ];
    }
}
