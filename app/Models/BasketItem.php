<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BasketItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'basket_id',
        'product_id',
        'product_variant_id',
        'quantity',
    ];

    /**
     * Get the basket that owns this item.
     */
    public function basket(): BelongsTo
    {
        return $this->belongsTo(Basket::class);
    }

    /**
     * Get the base product for this item.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the specific variant for this item (if applicable).
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    /**
     * Dynamic accessor to resolve price from variant or product fallback.
     */
    public function getUnitPriceAttribute(): float
    {
        if ($this->variant) {
            return (float) $this->variant->price;
        }

        return (float) ($this->product->price ?? 0.00);
    }
}