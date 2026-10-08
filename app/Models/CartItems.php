<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CartItems extends Model
{
    protected $table = 'cart_items';
    protected $primaryKey = 'cart_item_id';
    protected $fillable = [
        'cart_id',
        'flower_id',
        'item_type',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(
            Carts::class,
            'cart_id',
            'cart_id',
        );
    }

    public function flower(): HasMany
    {
        return $this->hasMany(
            Flowers::class,
            'flower_id',
            'flower_id',
        );
    }
}
