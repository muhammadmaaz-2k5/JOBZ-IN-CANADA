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
        Schema::table('resumes', function (Blueprint $table) {
            $table->string('google_drive_file_id')->nullable()->after('file_path');
            $table->string('folder_id')->nullable()->after('google_drive_file_id');
            $table->string('stored_name')->nullable()->after('original_name');
            $table->string('mime_type')->nullable()->after('stored_name');
            $table->string('extension')->nullable()->after('mime_type');
            $table->timestamp('uploaded_at')->nullable()->after('file_size');
        });

        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('type'); // Certificate / Cover Letter
            $table->string('google_drive_file_id');
            $table->string('original_name');
            $table->string('mime_type');
            $table->string('status')->default('active');
            $table->timestamp('uploaded_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');

        Schema::table('resumes', function (Blueprint $table) {
            $table->dropColumn([
                'google_drive_file_id',
                'folder_id',
                'stored_name',
                'mime_type',
                'extension',
                'uploaded_at'
            ]);
        });
    }
};
