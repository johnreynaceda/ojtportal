<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->string('photo')->nullable();
            $table->json('contact')->nullable();
            $table->json('hard_skill')->nullable();
            $table->json('soft_skill')->nullable();
            $table->json('education_background')->nullable();
            $table->json('character_reference')->nullable();
            $table->longText('career_objective')->nullable();
            $table->json('work_experience')->nullable();
            $table->json('award')->nullable();
            $table->json('certification')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
