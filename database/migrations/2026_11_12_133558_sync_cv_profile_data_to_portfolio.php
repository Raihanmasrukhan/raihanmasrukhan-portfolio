<?php

use Database\Seeders\DatabaseSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Synchronize production SQLite database with updated CV data without overwriting users or testimonials.
     */
    public function up(): void
    {
        DatabaseSeeder::syncCvData();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Intentionally left blank to preserve live portfolio records on rollback.
    }
};
