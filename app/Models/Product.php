<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'sku',
        'stock',
        'is_active',
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
