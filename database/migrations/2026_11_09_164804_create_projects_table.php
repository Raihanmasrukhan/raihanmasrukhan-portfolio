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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category')->default('saas'); // saas, enterprise, landing, other
            $table->string('badge')->nullable(); // SaaS & PWA, Enterprise System, etc.
            $table->string('client')->nullable();
            $table->string('role')->nullable();
            $table->string('timeline')->nullable();
            $table->text('overview')->nullable();
            $table->json('highlights')->nullable();
            $table->json('tech_stack')->nullable();
            $table->string('image')->default('images/project-saas.jpg');
            $table->string('live_url')->nullable();
            $table->string('github_url')->nullable();
            $table->string('video_url')->nullable();
            $table->string('video_duration', 50)->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_featured')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
