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
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_photo_public_id')->nullable()->after('profile_photo');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->string('logo_public_id')->nullable()->after('logo');
            $table->string('cover_image_public_id')->nullable()->after('cover_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['logo_public_id', 'cover_image_public_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile_photo_public_id');
        });
    }
};
