<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id('cart_item_id');

            $table->foreignId('cart_id')
                ->constrained('carts', 'cart_id')
                ->cascadeOnDelete();

            $table->foreignId('flower_id')
                ->constrained('flowers', 'flower_id')
                ->cascadeOnDelete();

            $table->string('item_type');

            $table->unsignedInteger('quantity');

            $table->decimal('unit_price', 10, 2);

            $table->decimal('subtotal', 10, 2);

            $table->timestamps();

            $table->unique([
                'cart_id',
                'flower_id',
                'item_type'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};