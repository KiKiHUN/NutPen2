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
        Schema::create('warnings', function (Blueprint $table) {
            $table->id('ID');
            $table->dateTime('DateTime');
            $table->string('Name');
            $table->string('Description');
            $table->string('TeacherID',6);
            $table->string('StudentID',6);

            $table->foreign('StudentID')->references('UserID')->on('students')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('TeacherID')->references('UserID')->on('teachers')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warnings');
    }
};
