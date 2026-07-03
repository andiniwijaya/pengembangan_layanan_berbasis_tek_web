<?php

namespace App\Support;

final class CategoryIcons
{
    /** @var array<string, string> */
    private const ICONS = [
        'coffee' => 'coffee',
        'stationery' => 'pencil',
        'home-living' => 'house',
        'organizer' => 'archive',
        'home-decor' => 'flower-2',
        'tumbler' => 'bottle',
        'mug' => 'cup-soda',
        'planner' => 'calendar-days',
        'notebook' => 'notebook-pen',
        'mini-plant' => 'leaf',
    ];

    public static function forSlug(string $slug): string
    {
        return self::ICONS[$slug] ?? 'tag';
    }
}
