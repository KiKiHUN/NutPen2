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
        Schema::create('home_work_students', function (Blueprint $table) {
            $table->string('StudentID',8);
            $table->unsignedBigInteger('HomeWorkID');
            $table->boolean('Done')->default(false);
            $table->dateTime('SubmitDateTime');
            $table->string('FilePath')->nullable();
            $table->string('Answer')->nullable();

            $table->foreign('StudentID')->references('UserID')->on('students')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('HomeWorkID')->references('ID')->on('home_works')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['StudentID', 'HomeWorkID'])->primary();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_work_students');
    }
};
