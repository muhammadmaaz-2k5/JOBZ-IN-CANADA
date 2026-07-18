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
        Schema::create('job_seeker_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('headline')->nullable();
            $table->text('summary')->nullable();
            $table->unsignedInteger('current_salary')->nullable();
            $table->unsignedInteger('expected_salary')->nullable();
            $table->string('notice_period')->nullable();
            $table->unsignedTinyInteger('experience_years')->nullable();
            $table->string('employment_preference')->nullable();
            $table->string('career_level')->nullable();
            $table->string('work_authorization')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('github')->nullable();
            $table->string('portfolio')->nullable();
            $table->string('website')->nullable();
            $table->unsignedTinyInteger('profile_completion')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_seeker_profiles');
    }
};
