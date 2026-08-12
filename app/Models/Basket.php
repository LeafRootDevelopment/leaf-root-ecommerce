<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    protected $fillable = [
        'session_id',
    ];

    public function items()
    {
        return $this->hasMany(BasketItem::class);
    }
}