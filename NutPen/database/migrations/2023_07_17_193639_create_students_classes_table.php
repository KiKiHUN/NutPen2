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
        Schema::create('students_classes', function (Blueprint $table) {
            $table->unsignedBigInteger('ClassID');
            $table->string('StudentID',8);
            $table->foreign('ClassID')->references('ID')->on('school_classes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('StudentID')->references('UserID')->on('students')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['StudentID', 'ClassID'])->primary();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students_classes');
    }
};
