<?php

namespace App\Support;

final class ImageAssets
{
    public const PLACEHOLDER_PRODUCT = 'images/placeholders/product.jpg';

    public const PLACEHOLDER_AVATAR = 'images/placeholders/avatar.jpg';

    public const BANNER_HERO_1 = 'images/banners/hero-1.jpg';

    public const BANNER_HERO_2 = 'images/banners/hero-2.jpg';

    public const BANNER_HERO_3 = 'images/banners/hero-3.jpg';

    public static function placeholderProduct(): string
    {
        return asset(self::PLACEHOLDER_PRODUCT);
    }

    public static function placeholderAvatar(): string
    {
        return asset(self::PLACEHOLDER_AVATAR);
    }

    public static function productPath(string $filename): string
    {
        return 'images/products/'.$filename;
    }

    public static function isStoragePath(?string $path): bool
    {
        if ($path === null || $path === '') {
            return false;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return false;
        }

        return ! str_starts_with($path, 'images/');
    }

    public static function url(?string $path, ?string $placeholder = null): string
    {
        if ($path === null || $path === '') {
            return asset($placeholder ?? self::PLACEHOLDER_PRODUCT);
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }

        return asset('storage/'.$path);
    }
}
