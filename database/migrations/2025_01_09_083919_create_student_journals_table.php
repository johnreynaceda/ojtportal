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
        Schema::create('student_journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id');
            $table->longText('objective');
            $table->longText('accomplishment');
            $table->longText('reflection');
            $table->longText('knowledge');
            $table->date('date');
            $table->string('status');
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
