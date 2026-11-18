<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomisationOption extends Model
{
    protected $table = 'customisation_options';

    protected $primaryKey = 'option_id';

    protected $fillable = [
        'option_name',
        'option_type',
        'description',
        'price',
        'stock_quantity',
        'image',
        'availability',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'stock_quantity' => 'integer',
            'availability' => 'boolean',
        ];
    }
}
