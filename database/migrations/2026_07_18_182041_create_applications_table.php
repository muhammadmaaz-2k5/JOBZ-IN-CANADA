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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('jobs')->onDelete('cascade');
            $table->foreignId('applicant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('resume_id')->constrained('resumes')->onDelete('cascade');
            $table->text('cover_letter')->nullable();
            $table->string('status')->default('applied'); // applied, pending_review, shortlisted, interview_scheduled, interview_completed, offered, hired, rejected, withdrawn
            $table->timestamp('applied_at')->useCurrent();
            $table->timestamp('withdrawn_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
