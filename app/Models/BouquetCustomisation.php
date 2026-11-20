<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BouquetCustomisation extends Model
{
    protected $table = 'bouquet_customisation';

    protected $primaryKey = 'customisation_id';

    protected $fillable = [
        'user_id',
        'bouquet_type',
        'special_request',
        'wrap_option_id',
        'ribbon_option_id',
        'theme_colour_option_id',
        'bouquet_style_option_id',
        'preview_image',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(
            CustomBouquetItem::class,
            'customisation_id',
            'customisation_id'
        );
    }

    public function wrappingOption(): BelongsTo
    {
        return $this->belongsTo(
            CustomisationOption::class,
            'wrap_option_id',
            'option_id'
        );
    }

    public function ribbonOption(): BelongsTo
    {
        return $this->belongsTo(
            CustomisationOption::class,
            'ribbon_option_id',
            'option_id'
        );
    }

    public function themeColourOption(): BelongsTo
    {
        return $this->belongsTo(
            CustomisationOption::class,
            'theme_colour_option_id',
            'option_id'
        );
    }

    public function bouquetStyleOption(): BelongsTo
    {
        return $this->belongsTo(
            CustomisationOption::class,
            'bouquet_style_option_id',
            'option_id'
        );
    }
}
