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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id('ID');
            $table->unsignedBigInteger('SubjectID');
            $table->date('StartDate');
            $table->date('EndDate');
            $table->integer('Minutes');
            $table->string('WeeklyTimes');
            $table->string('TeacherID',8);
            $table->boolean('Active')->default(true);

            $table->foreign('TeacherID')->references('UserID')->on('teachers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('SubjectID')->references('ID')->on('subjects')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
