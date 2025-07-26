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
        Schema::create('request_supplies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Add user_id field first
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('requester_name');
            $table->string('department');

            $table->string('item_name');
            $table->string('variant_value');
            $table->integer('quantity');
            $table->dateTime('datetime');
            $table->longText('signature');

            $table->text('description')->nullable();
            $table->string('chairman_status', 20)->default('pending');
            $table->string('dean_status', 20)->default('pending');
            $table->string('admin_status', 20)->default('pending');
            $table->string('date_needed')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->enum('withdrawal_status', [
                'Pending', // Changed to match your default
                'Processing', 
                'Ready to Pick Up', 
                'Completed'
            ])->default('Pending');
            $table->string('withdrawn_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_supplies');
    }
};