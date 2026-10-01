<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orders extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    protected $fillable =[
        'user_id',
        'order_date',
        'order_status',
        'total_amount',
        'remarks'
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(
            OrderItem::class,
            'order_id',
            'order id'
        );
    }
}
