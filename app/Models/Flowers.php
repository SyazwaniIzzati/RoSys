<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Flowers extends Model
{
    protected $table = 'flowers';
    protected $primaryKey = 'flower_id';
    protected $fillable = [
        'category_id',
        'flower_name',
        'description',
        'price_per_stem',
        'price_per_bunch',
        'stock_quantity',
        'minimum_order_quantity',
        'availability',
        'image',
    ];

    protected $casts = [
        'price_per_stem' => 'decimal:2',
        'price_per_bunch' => 'decimal:2',
        'availability' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            Category::class,
            'category_id',
            'category_id'
        );
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(
            OrderItem::class,
            'flower_id',
            'flower_id'
        );
    }

    public function customBouquetItems(): HasMany
    {
        return $this->hasMany(
            CustomBouquetItem::class,
            'flower_id',
            'flower_id'
        );
    }
}
