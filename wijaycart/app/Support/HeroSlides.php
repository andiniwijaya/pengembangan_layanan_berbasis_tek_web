<?php

namespace App\Support;

final class HeroSlides
{
    /**
     * @return list<array{image: string, title: string, subtitle: string, shop_url: string, catalog_url: string, alt: string}>
     */
    public static function all(): array
    {
        return [
            [
                'image' => asset(ImageAssets::BANNER_HERO_1),
                'alt' => 'Koleksi lifestyle modern WijayCart',
                'title' => 'Temukan Gaya Hidup Modern & Minimalis',
                'subtitle' => 'Koleksi premium home living, stationery, dan coffee essentials dengan nuansa warm elegant.',
                'shop_url' => route('products.index'),
                'catalog_url' => route('products.index', ['category' => 'home-living']),
            ],
            [
                'image' => asset(ImageAssets::BANNER_HERO_2),
                'alt' => 'Produk home decor pilihan WijayCart',
                'title' => 'Percantik Ruang Impian Anda',
                'subtitle' => 'Home decor dan organizer berkualitas untuk rumah yang lebih rapi dan estetik.',
                'shop_url' => route('products.index', ['category' => 'home-decor']),
                'catalog_url' => route('products.index'),
            ],
            [
                'image' => asset(ImageAssets::BANNER_HERO_3),
                'alt' => 'Stationery dan planner WijayCart',
                'title' => 'Produktivitas dengan Gaya',
                'subtitle' => 'Planner, notebook, dan alat tulis estetik untuk hari-hari yang lebih terorganisir.',
                'shop_url' => route('products.index', ['category' => 'stationery']),
                'catalog_url' => route('products.index', ['category' => 'planner']),
            ],
        ];
    }
}
