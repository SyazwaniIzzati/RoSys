
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customisation_options', function (Blueprint $table) {
            $table->id('option_id');

            $table->string('option_name');
            $table->string('option_type');
            $table->text('description')->nullable();

            $table->decimal('price', 10, 2)->default(0.00);
            $table->unsignedInteger('stock_quantity')->default(0);

            $table->string('image')->nullable();

            $table->boolean('availability')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customisation_options');
    }
};
