<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function basketItems()
    {
        return $this->hasMany(BasketItem::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
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