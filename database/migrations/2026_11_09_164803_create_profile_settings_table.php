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
        Schema::create('profile_settings', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->default('Raihan Adib Masrukhan');
            $table->string('hero_title_line1')->default('RAIHAN');
            $table->string('hero_title_prefix')->default('MAS');
            $table->string('hero_title_suffix')->default('RUKHAN');
            $table->string('headline')->default('Software Engineer & Full-Stack Web Developer');
            $table->text('sub_headline')->nullable();
            $table->string('location')->default('Based in Depok & Bogor, ID');
            $table->string('availability_status')->default('Available for Projects');
            $table->boolean('is_available')->default(true);
            $table->string('avatar')->default('images/hero.jpg');
            $table->json('hero_specialties')->nullable();
            $table->text('about_statement')->nullable();
            $table->string('phone')->default('+62 858-6445-9552');
            $table->string('whatsapp_number')->default('6285864459552');
            $table->string('email')->default('Raihanmasrukhan56@gmail.com');
            $table->string('github_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('cv_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_settings');
    }
};
