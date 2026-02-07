
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up(): void
    {
        // Make sure the parent table exists first
        if (Schema::hasTable('request_supplies')) {
            Schema::create('returns', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')
                    ->nullable()
                    ->constrained()
                    ->after('request_id')
                    ->cascadeOnDelete();
                // Foreign key to request_supplies
                $table->unsignedBigInteger('request_id');
                $table->foreign('request_id')
                    ->references('id')
                    ->on('request_supplies')
                    ->onDelete('cascade');

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
        } else {
            throw new \Exception('Parent table request_supplies does not exist. Run that migration first.');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
