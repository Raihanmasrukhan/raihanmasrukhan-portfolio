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
        Schema::rename('guestbooks', 'testimonials');

        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('role_title')->nullable()->after('name');
            $table->string('company')->nullable()->after('role_title');
            $table->string('project_tag')->nullable()->after('company');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['role_title', 'company', 'project_tag']);
        });

        Schema::rename('testimonials', 'guestbooks');
    }
};
