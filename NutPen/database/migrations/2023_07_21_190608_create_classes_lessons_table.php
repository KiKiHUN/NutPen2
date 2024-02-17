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
        Schema::create('classes_lessons', function (Blueprint $table) {
            $table->unsignedBigInteger('ClassID');
            $table->unsignedBigInteger('LessonID');
            $table->foreign('ClassID')->references('ID')->on('school_classes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('LessonID')->references('ID')->on('lessons')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['ClassID', 'LessonID'])->primary();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes_lessons');
    }
};
