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
        // Check if the table does not exist before creating it
        if (!Schema::hasTable('stocks')) {
            Schema::create('stocks', function (Blueprint $table) {
                $table->id();
                $table->string('item_name')->index();
                $table->integer('stock_quantity')->default(0)->index();
                $table->integer('reorderpoint')->default(0);
                $table->string('variant_type')->nullable();
                $table->string('variant_value')->nullable();
                $table->timestamps();

                // Prevent duplicate variants per item
                $table->index(['item_name', 'variant_value']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
