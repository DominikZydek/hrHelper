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
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('leave_type_id')->constrained('leave_types');
            $table->foreignId('approval_process_id')->constrained('approval_processes');
            $table->date('date_from');
            $table->date('date_to');
            $table->integer('days_count');
            $table->string('reason');
            $table->text('comment')->nullable();
            $table->enum('status', ['DRAFT', 'SENT', 'IN_PROGRESS', 'APPROVED', 'REJECTED', 'CANCELLED'])->default('DRAFT');
            $table->integer('current_approval_step')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
