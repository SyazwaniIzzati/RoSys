<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_bouquet_items', function (Blueprint $table) {
            $table->id('custom_bouquet_item_id');

            $table->foreignId('customisation_id')
                  ->constrained('bouquet_customisation', 'customisation_id')
                  ->cascadeOnDelete();

            $table->foreignId('flower_id')
                  ->constrained('flowers', 'flower_id')
                  ->cascadeOnDelete();

            $table->integer('quantity');

            $table->decimal('unit_price', 10, 2);

            $table->decimal('subtotal', 10, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_bouquet_items');
    }
};