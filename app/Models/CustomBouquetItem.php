<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomBouquetItem extends Model
{
    protected $table = 'custom_bouquet_items';
    protected $primaryKey = 'custom_bouquet_item_id';
    protected $fillable = [
        'customisation_id',
        'flower_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    protected $casts =[
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function customisation(): BelongsTo
    {
        return $this->belongsTo(
            BouquetCustomisation::class,
            'customisation_id',
            'customisation_id'
        );
    }

    public function flower(): BelongsTo
    {
        return $this->belongsTo(
            Flowers::class,
            'flower_id',
            'flower_id'
        );
    }
}
