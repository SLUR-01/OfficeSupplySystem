
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
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')
                ->constrained('request_supplies')
                ->cascadeOnDelete();
            $table->string('requester_name');
            $table->string('item_name')->index();
            $table->string('variant_value')->nullable()->index();

            $table->integer('quantity');
            $table->integer('quantity_received')->nullable();

            $table->string('department')->index();
            $table->date('return_date')->index();

            $table->enum('condition', ['defective', 'damaged', 'wrong_item'])->index();
            $table->enum('return_status', ['pending', 'approved', 'rejected'])
                ->default('pending')
                ->index();

            $table->enum('replacement_status', ['pending', 'completed'])->nullable()->index();

            $table->text('description')->nullable();
            $table->string('proof_image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
