<?php

namespace App\Support;

final class HeroSlides
{
    /**
     * @return list<array{gradient: string, icon: string, title: string, subtitle: string, shop_url: string, catalog_url: string, alt: string}>
     */
    public static function all(): array
    {
        return [
            [
                'gradient' => 'from-primary via-primary/80 to-secondary',
                'icon' => 'home',
                'alt' => 'Koleksi lifestyle modern WijayCart',
                'title' => 'Temukan Gaya Hidup Modern & Minimalis',
                'subtitle' => 'Koleksi premium home living dan mug keramik dengan nuansa warm elegant.',
                'shop_url' => route('products.index'),
                'catalog_url' => route('products.index', ['category' => 'home-living']),
            ],
            [
                'gradient' => 'from-secondary via-background to-primary/40',
                'icon' => 'flower-2',
                'alt' => 'Produk home decor pilihan WijayCart',
                'title' => 'Percantik Ruang Impian Anda',
                'subtitle' => 'Home decor berkualitas untuk rumah yang lebih rapi dan estetik.',
                'shop_url' => route('products.index', ['category' => 'home-decor']),
                'catalog_url' => route('products.index'),
            ],
            [
                'gradient' => 'from-accent/20 via-primary/60 to-secondary',
                'icon' => 'cup-soda',
                'alt' => 'Mug keramik WijayCart',
                'title' => 'Santai dengan Mug Favorit Anda',
                'subtitle' => 'Mug keramik premium untuk menemani setiap momen di rumah.',
                'shop_url' => route('products.index', ['category' => 'mug']),
                'catalog_url' => route('products.index', ['category' => 'home-living']),
            ],
        ];
    }
}
