
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            // Ordinary flower items can still use flower_id.
            // Custom bouquets will use customisation_id.
            $table->dropForeign('cart_items_flower_id_foreign');

            $table->unsignedBigInteger('flower_id')
                ->nullable()
                ->change();

            $table->foreign('flower_id')
                ->references('flower_id')
                ->on('flowers')
                ->cascadeOnDelete();

            $table->foreignId('customisation_id')
                ->nullable()
                ->constrained(
                    'bouquet_customisation',
                    'customisation_id'
                )
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign(['customisation_id']);
            $table->dropForeign(['flower_id']);

            // Rollback requires all cart items to have a flower_id.
            // Custom bouquet cart items must be removed first.
            $table->dropColumn('customisation_id');

            $table->unsignedBigInteger('flower_id')
                ->nullable(false)
                ->change();

            $table->foreign('flower_id')
                ->references('flower_id')
                ->on('flowers')
                ->cascadeOnDelete();
        });
    }
};
