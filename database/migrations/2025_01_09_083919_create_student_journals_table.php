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
        Schema::create('student_journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id');
            $table->date('date');
            $table->time('am_timein')->nullable();
            $table->time('am_timeout')->nullable();
            $table->time('pm_timein')->nullable();
            $table->time('pm_timeout')->nullable();
            $table->string('activities');
            $table->longText('problem_encountered')->nullable();
            $table->longText('reflection')->nullable();
            $table->double('no_of_hours');
            $table->string('status');
            $table->string('journal_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_journals');
    }
};
