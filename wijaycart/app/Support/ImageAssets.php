<?php

namespace App\Support;

final class ImageAssets
{
    public const PLACEHOLDER_PRODUCT = 'images/placeholders/product-placeholder.webp';

    public const PLACEHOLDER_AVATAR = 'images/placeholders/avatar-placeholder.webp';

    public const BANNER_HERO_1 = 'images/banners/hero-1.webp';

    public const BANNER_HERO_2 = 'images/banners/hero-2.webp';

    public const BANNER_HERO_3 = 'images/banners/hero-3.webp';

    public static function placeholderProduct(): string
    {
        return asset(self::PLACEHOLDER_PRODUCT);
    }

    public static function placeholderAvatar(): string
    {
        return asset(self::PLACEHOLDER_AVATAR);
    }

    public static function bannerHero(int $number = 1): string
    {
        $path = match ($number) {
            2 => self::BANNER_HERO_2,
            3 => self::BANNER_HERO_3,
            default => self::BANNER_HERO_1,
        };

        return asset($path);
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

    /** @deprecated Use url() */
    public static function storageUrl(?string $path, string $placeholder): string
    {
        return self::url($path, $placeholder);
    }
}
