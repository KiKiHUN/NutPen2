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
        Schema::create('sex_types', function (Blueprint $table) {
            $table->unsignedSmallInteger('ID')->autoIncrement();
            $table->string('Name',20);
            $table->string('Description',200)->nullable();
            $table->string('Title',200);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sex_types');
    }
};
