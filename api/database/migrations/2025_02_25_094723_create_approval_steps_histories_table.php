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
        Schema::create('approval_steps_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leave_request_id')->constrained('leave_requests');
            $table->integer('step');
            $table->enum('status', ['DRAFT', 'SENT', 'IN_PROGRESS', 'APPROVED', 'REJECTED', 'CANCELLED']);
            $table->foreignId('approver_id')->nullable()->constrained('users');
            $table->text('comment')->nullable();
            $table->timestamp('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_steps_histories');
    }
};
