<?php

namespace App\Models;

use App\Support\ImageAssets;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'category_id',
        'supplier_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'barcode',
        'status',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_featured' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    public function getPrimaryImageUrlAttribute(): string
    {
        $primary = $this->primaryImage;
        if ($primary) {
            return $primary->url;
        }

        $first = $this->images->first();
        if ($first) {
            return $first->url;
        }

        return ImageAssets::placeholderProduct();
    }

    public function getAverageRatingAttribute(): float
    {
        if (isset($this->reviews_avg_rating)) {
            return round((float) $this->reviews_avg_rating, 1);
        }

        $avg = $this->reviews()->avg('rating');

        return round((float) ($avg ?? 0), 1);
    }

    public function getReviewCountAttribute(): int
    {
        if (isset($this->reviews_count)) {
            return (int) $this->reviews_count;
        }

        return $this->reviews()->count();
    }

    /** Label status stok untuk card produk. */
    public function getStockLabelAttribute(): string
    {
        if ($this->stock <= 0) {
            return 'Habis';
        }

        if ($this->stock <= 10) {
            return 'Stok Terbatas';
        }

        return 'Tersedia';
    }

    /** Warna badge status stok. */
    public function getStockColorAttribute(): string
    {
        if ($this->stock <= 0) {
            return 'danger';
        }

        if ($this->stock <= 10) {
            return 'warning';
        }

        return 'success';
    }
}
