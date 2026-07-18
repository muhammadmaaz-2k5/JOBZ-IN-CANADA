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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->foreignId('employer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->text('responsibilities')->nullable();
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();
            $table->string('employment_type'); // full_time, part_time, contract, internship, temporary
            $table->string('workplace_type'); // remote, hybrid, onsite
            $table->string('experience_level'); // entry, mid, senior, lead, executive
            $table->string('education_level')->nullable();
            $table->string('salary_type')->nullable(); // hourly, monthly, yearly
            $table->unsignedInteger('salary_min')->nullable();
            $table->unsignedInteger('salary_max')->nullable();
            $table->string('currency')->default('CAD');
            $table->unsignedInteger('vacancies')->default(1);
            $table->string('location');
            $table->string('country')->default('Canada');
            $table->string('city');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamp('application_deadline')->nullable();
            $table->string('status')->default('active'); // draft, active, filled, expired
            $table->boolean('featured')->default(false);
            $table->boolean('urgent')->default(false);
            $table->boolean('auto_close_on_deadline')->default(true);
            $table->boolean('allow_cover_letter')->default(true);
            $table->boolean('resume_required')->default(true);
            $table->boolean('portfolio_required')->default(false);
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('applications_count')->default(0);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
