<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany as RelationsHasMany;
use Illuminate\Databse\Eloquent\Relations\HasMany;

class BouquetCustomisation extends Model
{
    protected $table = 'bouquet_customisation';
    protected $primaryKey = 'customisation_id';
    protected $fillable = [
        'order_item_id',
        'bouquet_type',
        'style',
        'colour_theme',
        'special_request',
        'wrap_option',
        'ribbon_option'
    ];

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(
            OrderItem::class,
            'order_item_id',
            'order_item_id'
        );
    }

    public function items(): RelationsHasMany
    {
        return $this->hasMany(
            CustomBouquetItem::class,
            'customisation_id',
            'customisation_id'
        );
    }
}
