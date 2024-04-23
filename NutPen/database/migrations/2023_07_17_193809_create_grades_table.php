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
        Schema::create('grades', function (Blueprint $table) {
            $table->id('ID');
            $table->dateTime('DateTime');
            $table->unsignedBigInteger('LessonID');
            $table->string('StudentID',8);
            $table->unsignedBigInteger('GradeTypeID');

            $table->foreign('StudentID')->references('UserID')->on('students')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('LessonID')->references('ID')->on('lessons')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('GradeTypeID')->references('ID')->on('grade_types')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
