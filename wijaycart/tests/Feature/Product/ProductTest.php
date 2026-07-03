<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    public function test_product_catalog_page_loads(): void
    {
        Category::factory()->create();
        Product::factory()->count(3)->create(['status' => 'active']);

        $this->get(route('products.index'))
            ->assertOk()
            ->assertViewIs('products.index');
    }

    public function test_product_detail_page_loads_by_slug(): void
    {
        $product = Product::factory()->create(['status' => 'active']);

        $this->get(route('products.show', $product->slug))
            ->assertOk()
            ->assertViewIs('products.show')
            ->assertSee($product->name, false);
    }

    public function test_inactive_product_returns_not_found(): void
    {
        $product = Product::factory()->create(['status' => 'inactive']);

        $this->get(route('products.show', $product->slug))->assertNotFound();
    }

    public function test_product_search_filters_results(): void
    {
        $category = Category::factory()->create();
        Product::factory()->create(['name' => 'Unique Mug Special', 'category_id' => $category->id, 'status' => 'active']);
        Product::factory()->create(['name' => 'Other Item', 'category_id' => $category->id, 'status' => 'active']);

        $this->get(route('products.index', ['search' => 'Unique Mug']))
            ->assertOk()
            ->assertSee('Unique Mug Special', false)
            ->assertDontSee('Other Item', false);
    }
}
