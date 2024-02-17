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
        Schema::create('school_infos', function (Blueprint $table) {
            $table->id('ID');
            $table->string('Name');
            $table->integer('SchoolNumber');
            $table->string('Phone',20);
            $table->string('Email',100);
            $table->unsignedSmallInteger('PostalCode');
            $table->string('FullAddress');
            $table->string('Text1');
            $table->string('Text2');
            $table->integer('Number1');
            $table->integer('Number2');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_infos');
    }
};
