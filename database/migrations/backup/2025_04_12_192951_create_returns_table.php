<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('request_id');
            $table->unsignedBigInteger('user_id');
            $table->string('requester_name');
            $table->string('item_name');
            $table->foreign('item_id')
            ->references('id')
            ->on('stocks')
            ->onDelete('cascade');
            $table->integer('quantity');
            $table->integer('quantity_received')->nullable();
            $table->string('department');
            $table->date('return_date');
            $table->enum('condition', ['defective', 'damaged', 'other']);
            $table->text('description')->nullable();
            $table->string('proof_image')->nullable();
            $table->enum('return_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('replacement_status', ['pending', 'completed'])->nullable();
            $table->timestamps();
            
            $table->foreign('request_id')->references('id')->on('request_supplies');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};