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
        Schema::create('head_users', function (Blueprint $table) {
            $table->string('UserID',8)->unique()->primary();
            $table->string('password',60);
            $table->string('FName',50);
            $table->string('LName',50);
            $table->unsignedSmallInteger('SexTypeID');
            $table->string('Email',100);
            $table->string('Phone',20);
            $table->unsignedBigInteger('RoleTypeID');
            $table->dateTime('LastLogin');
            $table->boolean('Enabled')->default(true);
            $table->boolean('DefaultPassword')->default(true);

            $table->foreign('RoleTypeID')->references('ID')->on('role_types')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('SexTypeID')->references('ID')->on('sex_types')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('head_users');
    }
};
