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
        Schema::create('recommendation_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id');
            $table->boolean('work_experience');
            $table->string('internship_location')->nullable();
            $table->string('internship_arrangement')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommendation_responses');
    }
};
