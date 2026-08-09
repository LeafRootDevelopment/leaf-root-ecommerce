<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
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

    protected function formattedPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => '£' . number_format($this->price, 2),
        );
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}