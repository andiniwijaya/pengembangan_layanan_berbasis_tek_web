<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_home_page_loads_successfully(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertViewIs('home');
        $response->assertSee('Temukan Gaya Hidup', false);
    }

    public function test_home_page_contains_hero_carousel(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('id="hero-carousel"', false);
        $response->assertSee('Belanja Sekarang', false);
        $response->assertSee('Lihat Katalog', false);
    }
}
