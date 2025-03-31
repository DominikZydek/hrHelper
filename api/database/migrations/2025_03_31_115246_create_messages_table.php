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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('users');
            $table->string('subject');
            $table->foreignId('message_category_id')->constrained('message_categories');
            $table->text('content');
            $table->integer('priority');
            $table->dateTime('publication_date');
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->boolean('require_confirmation');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
