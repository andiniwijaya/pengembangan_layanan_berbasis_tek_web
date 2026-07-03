<?php

namespace App\Http\Requests\Admin;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        $product = $this->route('product');

        if ($product) {
            return $this->user()->can('update', $product);
        }

        return $this->user()->can('create', Product::class);
    }

    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return [
            'category_id' => ['required', 'exists:categories,id'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($productId)],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'barcode' => ['nullable', 'string', Rule::unique('products', 'barcode')->ignore($productId)],
            'status' => ['required', 'in:active,inactive'],
            'is_featured' => ['nullable', 'boolean'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:2048'],
        ];
    }

    public function attributes(): array
    {
        return [
            'category_id' => 'kategori',
            'supplier_id' => 'supplier',
            'name' => 'nama produk',
            'slug' => 'slug',
            'description' => 'deskripsi',
            'price' => 'harga',
            'stock' => 'stok',
            'barcode' => 'barcode',
            'status' => 'status',
            'is_featured' => 'produk unggulan',
            'images' => 'gambar produk',
            'images.*' => 'gambar produk',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategori wajib dipilih.',
            'category_id.exists' => 'Kategori tidak ditemukan.',
            'supplier_id.exists' => 'Supplier tidak ditemukan.',
            'name.required' => 'Nama produk wajib diisi.',
            'name.max' => 'Nama produk maksimal 255 karakter.',
            'slug.max' => 'Slug maksimal 255 karakter.',
            'slug.unique' => 'Slug produk sudah digunakan.',
            'description.required' => 'Deskripsi produk wajib diisi.',
            'price.required' => 'Harga wajib diisi.',
            'price.numeric' => 'Harga harus berupa angka.',
            'price.min' => 'Harga tidak boleh negatif.',
            'stock.required' => 'Stok wajib diisi.',
            'stock.integer' => 'Stok harus berupa angka bulat.',
            'stock.min' => 'Stok tidak boleh negatif.',
            'barcode.unique' => 'Barcode sudah digunakan.',
            'status.required' => 'Status produk wajib dipilih.',
            'status.in' => 'Status produk tidak valid.',
            'is_featured.boolean' => 'Produk unggulan tidak valid.',
            'images.array' => 'Format gambar produk tidak valid.',
            'images.*.image' => 'Setiap file gambar harus berformat JPEG, PNG, atau GIF.',
            'images.*.max' => 'Ukuran setiap gambar maksimal 2 MB.',
        ];
    }

    protected function prepareForValidation(): void
    {
        if (! $this->slug && $this->name) {
            $this->merge(['slug' => Str::slug($this->name)]);
        }

        $this->merge([
            'is_featured' => $this->boolean('is_featured'),
        ]);
    }
}
