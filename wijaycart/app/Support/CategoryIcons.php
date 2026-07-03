<?php

namespace App\Support;

final class CategoryIcons
{
    /** @var array<string, string> */
    private const ICONS = [
        'home-living' => 'house',
        'home-decor' => 'flower-2',
        'mug' => 'cup-soda',
    ];

    public static function forSlug(string $slug): string
    {
        return self::ICONS[$slug] ?? 'tag';
    }
}
