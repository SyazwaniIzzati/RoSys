
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bouquet_customisation', function (Blueprint $table) {
            // A customisation is created before an order item exists.
            $table->dropForeign(
                'bouquet_customisation_order_items_foreign'
            );

            $table->dropColumn('order_items');

            // Nullable temporarily to preserve any existing records.
            // New customisations should always have an authenticated owner.
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('wrap_option_id')
                ->nullable()
                ->constrained('customisation_options', 'option_id')
                ->nullOnDelete();

            $table->foreignId('ribbon_option_id')
                ->nullable()
                ->constrained('customisation_options', 'option_id')
                ->nullOnDelete();

            $table->foreignId('theme_colour_option_id')
                ->nullable()
                ->constrained('customisation_options', 'option_id')
                ->nullOnDelete();

            $table->foreignId('bouquet_style_option_id')
                ->nullable()
                ->constrained('customisation_options', 'option_id')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('bouquet_customisation', function (Blueprint $table) {
            $table->dropForeign(['wrap_option_id']);
            $table->dropForeign(['ribbon_option_id']);
            $table->dropForeign(['theme_colour_option_id']);
            $table->dropForeign(['bouquet_style_option_id']);
            $table->dropForeign(['user_id']);

            $table->dropColumn([
                'user_id',
                'wrap_option_id',
                'ribbon_option_id',
                'theme_colour_option_id',
                'bouquet_style_option_id',
            ]);

            // Restore the original relationship as nullable so existing
            // pre-order customisations can remain without an order item.
            $table->foreignId('order_items')
                ->nullable()
                ->constrained('order_items', 'order_item_id')
                ->cascadeOnDelete();
        });
    }
};
