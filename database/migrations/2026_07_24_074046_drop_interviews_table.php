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
        Schema::dropIfExists('interviews');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            $table->string('interview_type');
            $table->dateTime('scheduled_at');
            $table->string('meeting_link')->nullable();
            $table->string('interviewer')->nullable();
            $table->string('status')->default('scheduled');
            $table->timestamps();
        });
    }
};
