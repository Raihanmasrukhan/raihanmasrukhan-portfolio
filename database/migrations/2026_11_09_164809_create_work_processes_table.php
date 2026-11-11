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
        Schema::create('work_processes', function (Blueprint $table) {
            $table->id();
            $table->string('step_number'); // e.g. 1. or 2.
            $table->string('title');
            $table->text('description');
            $table->boolean('is_featured')->default(false); // highlights with vivid orange
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_processes');
    }
};
