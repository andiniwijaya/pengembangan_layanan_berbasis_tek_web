<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Support\ImageAssets;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'category_id' => Category::factory(),
            'supplier_id' => Supplier::factory(),
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => fake()->paragraphs(3, true),
            'price' => fake()->numberBetween(25000, 350000),
            'stock' => fake()->numberBetween(5, 100),
            'barcode' => 'PRD'.str_pad((string) fake()->unique()->numberBetween(1, 999999), 6, '0', STR_PAD_LEFT),
            'status' => 'active',
            'is_featured' => fake()->boolean(30),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Product $product) {
            $product->images()->create([
                'image_path' => ImageAssets::productPath('ceramic-minimalist-mug.webp'),
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        });
    }
}
