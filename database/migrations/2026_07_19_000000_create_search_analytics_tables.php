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
        Schema::create('search_queries', function (Blueprint $table) {
            $table->id();
            $table->string('query_string')->nullable();
            $table->json('filters')->nullable();
            $table->unsignedInteger('results_count')->default(0);
            $table->unsignedInteger('search_time_ms')->default(0);
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });

        Schema::table('jobs', function (Blueprint $table) {
            $table->index(['title']);
            $table->index(['city']);
            $table->index(['country']);
            $table->index(['salary_min']);
            $table->index(['salary_max']);
            $table->index(['published_at']);
            $table->index(['status']);
            $table->index(['application_deadline']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropIndex(['title']);
            $table->dropIndex(['city']);
            $table->dropIndex(['country']);
            $table->dropIndex(['salary_min']);
            $table->dropIndex(['salary_max']);
            $table->dropIndex(['published_at']);
            $table->dropIndex(['status']);
            $table->dropIndex(['application_deadline']);
        });

        Schema::dropIfExists('search_queries');
    }
};
