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
        Schema::create('bouquet_customisation', function (Blueprint $table) {
            $table->id('customisation_id');
            $table->foreignId('order_items')
                  ->constrained('order_items', 'order_item_id')
                  ->cascadeOnDelete();
            $table->string('bouquet_type')->nullable();
            $table->string('colour_theme')->nullable();
            $table->string('style')->nullable();
            $table->text('special_request')->nullable();
            $table->string('wrap_option')->nullable();
            $table->string('ribbon_option')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bouquet_customisation');
    }
};
