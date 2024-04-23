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
        Schema::create('lates_missings', function (Blueprint $table) {
            $table->id('ID');
            $table->unsignedBigInteger('LessonID');
            $table->string('StudentID',8);
            $table->unsignedSmallInteger('MissedMinute');
            $table->dateTime('DateTime');
            $table->boolean('Verified');
            $table->string('VerifiedByID',8);
            $table->unsignedBigInteger('VerificationTypeID');


            $table->foreign('StudentID')->references('UserID')->on('students')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('LessonID')->references('ID')->on('lessons')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('VerificationTypeID')->references('ID')->on('verification_types')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lates_missings');
    }
};
