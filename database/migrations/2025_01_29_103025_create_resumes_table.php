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
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('photo');
            $table->json('contact');
            $table->json('hard_skill');
            $table->json('soft_skill');
            $table->json('education_background');
            $table->json('character_reference');
            $table->longText('career_objective');
            $table->json('work_experience');
            $table->json('award');
            $table->json('certification');
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
