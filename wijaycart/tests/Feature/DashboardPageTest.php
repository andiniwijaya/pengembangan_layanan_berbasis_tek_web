<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\User;
use Tests\TestCase;

class DashboardPageTest extends TestCase
{
    public function test_guest_cannot_access_dashboard(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_customer_can_access_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'customer']);
        Cart::create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertViewIs('dashboard.index');
        $response->assertSee('Total Pesanan', false);
        $response->assertSee('Produk Rekomendasi', false);
    }
}
