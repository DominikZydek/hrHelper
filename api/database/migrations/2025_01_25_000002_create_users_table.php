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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->enum('sex', ['M', 'F', 'X']);
            $table->string('email')->unique();
            $table->date('birth_date');
            $table->string('phone_number');
            $table->foreignId('address_id')->constrained('addresses');
            $table->string('job_title');
            $table->foreignId('supervisor_id')->nullable()->constrained('users');
            $table->foreignId('approval_process_id')->constrained('approval_processes');
            $table->enum('type_of_employment', ['UoP', 'B2B']);
            $table->integer('paid_time_off_days');
            $table->float('working_time');
            $table->date('employed_from');
            $table->date('employed_to')->nullable();
            $table->date('health_check_expired_by');
            $table->date('health_and_safety_training_expired_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
