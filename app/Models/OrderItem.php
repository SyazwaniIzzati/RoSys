<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $primaryKey = 'order_item_id';
    protected $fillable = [
        'order_id',
        'flower_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function flower(): BelongsTo
    {
        return $this->belongsTo(
            Flowers::class,
            'flower_id',
            'flower_id'
        );
    }

    public function bouquetCustomisation(): HasOne
    {
        return $this->hasOne(
            BouquetCustomisation::class,
            'order_item_id',
            'order_item_id'
        );
    }
}
