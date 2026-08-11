<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'is_active',
    ];

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all basket items associated with this product.
     */
    public function basketItems(): HasMany
    {
        return $this->hasMany(BasketItem::class);
    }

    /**
     * Get all variants associated with this product.
     */
    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Get all order line items associated with this product.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Formatted price accessor.
     */
    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => '£' . number_format($this->price, 2),
        );
    }

    /**
     * Check if product is in stock (safely defaults to true if stock column is null or unpopulated).
     */
    public function isInStock(): bool
    {
        if (!array_key_exists('stock', $this->attributes) || $this->stock === null) {
            return true;
        }

        return (int) $this->stock > 0;
    }

    /**
     * Get maximum purchasable quantity.
     */
    public function getMaxQuantityAttribute(): int
    {
        if (!array_key_exists('stock', $this->attributes) || $this->stock === null) {
            return 99;
        }

        return max(0, min((int) $this->stock, 99));
    }
}