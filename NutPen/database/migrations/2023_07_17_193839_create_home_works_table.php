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
        Schema::create('home_works', function (Blueprint $table) {
            $table->id('ID');
            $table->unsignedBigInteger('LessonID');
            $table->string('Name');
            $table->string('Description');
            $table->dateTime('StartDateTime');
            $table->dateTime('EndDateTime');
            $table->boolean('Active')->default(true);

            $table->foreign('LessonID')->references('ID')->on('lessons')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_works');
    }
};
