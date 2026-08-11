<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size_label',
        'price',
        'stock_qty',
        'low_stock_threshold',
        'stock_status',
    ];

    /**
     * Get the base product that owns this variant.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
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
     * Check if this variant is currently in stock.
     */
    public function isInStock(): bool
    {
        return (int) $this->stock_qty > 0;
    }
}