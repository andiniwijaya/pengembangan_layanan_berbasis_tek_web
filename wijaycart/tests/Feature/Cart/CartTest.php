<?php

namespace Tests\Feature\Cart;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\CreatesCommerceFixtures;
use Tests\TestCase;

class CartTest extends TestCase
{
    use CreatesCommerceFixtures;
    use RefreshDatabase;

    public function test_guest_cannot_access_cart(): void
    {
        $this->get(route('cart.index'))->assertRedirect(route('login'));
    }

    public function test_customer_can_view_empty_cart(): void
    {
        [$user] = $this->createCustomerWithCart();
        $user->cart->items()->delete();

        $this->actingAs($user)->get(route('cart.index'))
            ->assertOk()
            ->assertViewIs('cart.index');
    }

    public function test_customer_can_add_product_to_cart(): void
    {
        [$user, $product] = $this->createCustomerWithCart();

        $response = $this->actingAs($user)->post(route('cart.store'), [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    public function test_add_to_cart_fails_when_stock_insufficient(): void
    {
        [$user, $product] = $this->createCustomerWithCart(quantity: 10);
        $product->update(['stock' => 10]);

        $this->actingAs($user)->post(route('cart.store'), [
            'product_id' => $product->id,
            'quantity' => 1,
        ])->assertRedirect()->assertSessionHas('error');
    }

    public function test_customer_can_update_cart_item_quantity(): void
    {
        [$user, $product] = $this->createCustomerWithCart();
        $item = CartItem::where('product_id', $product->id)->first();

        $this->actingAs($user)->put(route('cart.update', $item), [
            'quantity' => 3,
        ])->assertRedirect();

        $this->assertSame(3, $item->fresh()->quantity);
    }

    public function test_customer_can_remove_cart_item(): void
    {
        [$user, $product] = $this->createCustomerWithCart();
        $item = CartItem::where('product_id', $product->id)->first();

        $this->actingAs($user)->delete(route('cart.destroy', $item))->assertRedirect();
        $this->assertDatabaseMissing('cart_items', ['id' => $item->id]);
    }

    public function test_add_to_cart_via_json_returns_cart_payload(): void
    {
        [$user, $product] = $this->createCustomerWithCart();
        $user->cart->items()->delete();

        $response = $this->actingAs($user)->postJson(route('cart.store'), [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response->assertOk()->assertJsonStructure(['message', 'cart' => ['items', 'subtotal', 'item_count']]);
    }
}
