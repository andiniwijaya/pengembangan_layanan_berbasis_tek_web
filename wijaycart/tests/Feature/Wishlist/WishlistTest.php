<?php

namespace Tests\Feature\Wishlist;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesCommerceFixtures;
use Tests\TestCase;

class WishlistTest extends TestCase
{
    use CreatesCommerceFixtures;
    use RefreshDatabase;

    public function test_guest_cannot_access_wishlist(): void
    {
        $this->get(route('wishlist.index'))->assertRedirect(route('login'));
    }

    public function test_customer_can_add_product_to_wishlist(): void
    {
        [$user, $product] = $this->createCustomerWithCart();
        $user->cart->items()->delete();

        $this->actingAs($user)->post(route('wishlist.toggle', $product))->assertRedirect();

        $this->assertDatabaseHas('wishlists', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);
    }

    public function test_customer_can_remove_product_from_wishlist(): void
    {
        [$user, $product] = $this->createCustomerWithCart();
        $wishlist = Wishlist::create(['user_id' => $user->id, 'product_id' => $product->id]);

        $this->actingAs($user)->post(route('wishlist.toggle', $product))->assertRedirect();
        $this->assertDatabaseMissing('wishlists', ['id' => $wishlist->id]);
    }

    public function test_customer_can_view_wishlist_page(): void
    {
        [$user, $product] = $this->createCustomerWithCart();
        Wishlist::create(['user_id' => $user->id, 'product_id' => $product->id]);

        $this->actingAs($user)->get(route('wishlist.index'))
            ->assertOk()
            ->assertViewIs('wishlist.index');
    }
}
