<?php

namespace Tests\Concerns;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;

trait CreatesCommerceFixtures
{
    protected function seedShippingSetting(): void
    {
        Setting::set('shipping_cost', '15000');
    }

    protected function createCustomerWithCart(?Product $product = null, int $quantity = 1): array
    {
        $user = User::factory()->create();
        Cart::create(['user_id' => $user->id]);

        if ($product === null) {
            $category = Category::factory()->create();
            $product = Product::factory()->create([
                'category_id' => $category->id,
                'stock' => 20,
                'status' => 'active',
            ]);
        }

        $cart = $user->cart ?? Cart::create(['user_id' => $user->id]);
        CartItem::create([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
        ]);

        return [$user, $product];
    }

    protected function createAdminUser(): User
    {
        return User::factory()->admin()->create([
            'password' => bcrypt('password'),
        ]);
    }
}
