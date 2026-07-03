<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_home_page_loads_successfully(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertViewIs('home');
        $response->assertSee('Kategori', false);
        $response->assertSee('Produk Unggulan', false);
    }

    public function test_home_page_does_not_contain_hero_carousel(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertDontSee('id="hero-carousel"', false);
        $response->assertSee('Jelajahi koleksi berdasarkan kategori', false);
    }
}
