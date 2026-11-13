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
        if (! Schema::hasColumn('projects', 'video_url')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->string('video_url')->nullable()->after('github_url');
                $table->string('video_duration', 50)->nullable()->after('video_url');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['video_url', 'video_duration']);
        });
    }
};
