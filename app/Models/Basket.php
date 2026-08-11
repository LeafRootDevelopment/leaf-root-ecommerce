<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Basket extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
    ];

    /**
     * Get the user that owns this basket (nullable for guest baskets).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all items in this basket.
     */
    public function items(): HasMany
    {
        return $this->hasMany(BasketItem::class);
    }

    /**
     * Calculate total monetary value of items in the basket.
     */
    public function getTotalAttribute(): float
    {
        return (float) $this->items->sum(function (BasketItem $item) {
            return $item->unit_price * $item->quantity;
        });
    }
}