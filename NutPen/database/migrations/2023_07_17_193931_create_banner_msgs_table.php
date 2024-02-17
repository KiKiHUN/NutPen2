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
        Schema::create('banner_msgs', function (Blueprint $table) {
            $table->id('ID');
            $table->unsignedBigInteger('messageTypeID');
            $table->string('Header');
            $table->string('Description')->nullable();
            $table->string('ImagePath')->nullable();
            $table->boolean('Enabled')->default(false);

            $table->foreign('messageTypeID')->references('ID')->on('bannertypes')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banner_msgs');
    }
};
