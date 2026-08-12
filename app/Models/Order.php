<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'total',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
        ];
    }

    /**
     * Get the user who placed this order (nullable for guest checkout).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the delivery address linked to this order.
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Relationship: An order has many items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Interact with the order status attribute.
     * Normalizes case variations (e.g., 'pending' -> 'Pending') gracefully.
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                if ($value instanceof OrderStatus) {
                    return $value;
                }

                $normalized = ucfirst(strtolower((string) $value));

                return OrderStatus::tryFrom($normalized) 
                    ?? OrderStatus::tryFrom($value) 
                    ?? OrderStatus::Pending;
            },
            set: fn ($value) => $value instanceof OrderStatus ? $value->value : $value,
        );
    }

    /**
     * Accessor for customer's full name (via linked User or fallback).
     */
    public function getFullNameAttribute(): string
    {
        if ($this->user) {
            return trim(
                ($this->user->first_name ?? '') . ' ' .
                ($this->user->last_name ?? '')
            );
        }

        return 'Guest Customer';
    }

    /**
     * Scope query to search orders by ID, Customer Name, or Email via relations.
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) {
            return $query;
        }

        $term = trim($term);
        $escapedTerm = addcslashes($term, '%_\\');

        return $query->where(function (Builder $subQuery) use ($term, $escapedTerm) {
            if (is_numeric($term)) {
                $subQuery->orWhere('id', (int) $term);
            }

            $subQuery->orWhereHas('user', function (Builder $userQuery) use ($escapedTerm) {
                $userQuery->where('first_name', 'like', "%{$escapedTerm}%")
                    ->orWhere('last_name', 'like', "%{$escapedTerm}%")
                    ->orWhere('email', 'like', "%{$escapedTerm}%");
            });
        });
    }
}