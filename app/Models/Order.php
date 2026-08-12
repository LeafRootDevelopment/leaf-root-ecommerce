<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'postcode',
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
     * Relationship: An order has many items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Accessor for customer's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Scope query to search orders by ID, First Name, Last Name, or Email.
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

            $subQuery->orWhere('first_name', 'like', "%{$escapedTerm}%")
                ->orWhere('last_name', 'like', "%{$escapedTerm}%")
                ->orWhere('email', 'like', "%{$escapedTerm}%");
        });
    }
}