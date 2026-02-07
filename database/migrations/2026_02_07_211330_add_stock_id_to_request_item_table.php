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
        Schema::table('request_items', function (Blueprint $table) {
            // Only add the column if it doesn't already exist
            if (!Schema::hasColumn('request_items', 'stock_id')) {
                $table->unsignedBigInteger('stock_id')->nullable()->index()->after('id');

                // Add foreign key constraint
                $table->foreign('stock_id')
                    ->references('id')
                    ->on('stocks')
                    ->onDelete('cascade'); // deletes request_item if related stock is deleted
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_items', function (Blueprint $table) {
            // Drop the foreign key and column if it exists
            if (Schema::hasColumn('request_items', 'stock_id')) {
                $table->dropForeign(['stock_id']);
                $table->dropColumn('stock_id');
            }
        });
    }
};
