<?php

namespace App\Http\Requests\Admin;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        $category = $this->route('category');

        if ($category) {
            return $this->user()->can('update', $category);
        }

        return $this->user()->can('create', Category::class);
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($categoryId)],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama kategori',
            'slug' => 'slug',
            'description' => 'deskripsi',
            'is_active' => 'status aktif',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.max' => 'Nama kategori maksimal 255 karakter.',
            'slug.max' => 'Slug maksimal 255 karakter.',
            'slug.unique' => 'Slug kategori sudah digunakan.',
            'is_active.boolean' => 'Status aktif tidak valid.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (! $this->slug && $this->name) {
            $this->merge(['slug' => Str::slug($this->name)]);
        }
    }
}
