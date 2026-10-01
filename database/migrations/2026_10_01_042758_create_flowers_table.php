<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('flowers', function (Blueprint $table) {
            $table->id('flower_id');
            $table->foreignId('category_id')
                  ->constrained('categories', 'category_id')
                  ->cascadeOnDelete();
            $table->string('flower_name');
            $table->text('description');
            $table->decimal('price_per_stem', 10, 2)->nullable();
            $table->decimal('price_per_bunch', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(0);
            $table->integer('minimun_order_quantity')->default(1);
            $table->boolean('availability')->default(true);
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flowers');
    }
};
