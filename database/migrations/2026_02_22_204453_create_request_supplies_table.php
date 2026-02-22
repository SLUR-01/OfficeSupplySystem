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

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->index('user_id');

            $table->string('requester_name');
            $table->string('department')->index();


            $table->dateTime('datetime')->index();

            $table->longText('signature');
            $table->text('description')->nullable();

            $table->string('admin_status', 20)->default('pending')->index();
            $table->date('date_needed')->nullable()->index();

            $table->dateTime('completed_at')->nullable()->index();

            $table->enum('withdrawal_status', [
                'Pending',
                'Ready to Pick Up',
                'Completed'
            ])->default('Pending')->index();

            $table->string('withdrawn_by')->nullable();
            $table->timestamps();

            // 🔥 Composite index for admin filtering
            $table->index(['admin_status', 'withdrawal_status']);
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
