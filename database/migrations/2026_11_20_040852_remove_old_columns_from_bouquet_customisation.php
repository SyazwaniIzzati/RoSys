
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bouquet_customisation', function (Blueprint $table) {
            $table->dropColumn([
                'colour_theme',
                'style',
                'wrap_option',
                'ribbon_option',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('bouquet_customisation', function (Blueprint $table) {
            $table->string('colour_theme')->nullable();
            $table->string('style')->nullable();
            $table->string('wrap_option')->nullable();
            $table->string('ribbon_option')->nullable();
        });
    }
};
