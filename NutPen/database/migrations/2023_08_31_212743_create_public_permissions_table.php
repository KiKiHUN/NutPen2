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
        Schema::create('public_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('status');
            $table->unsignedBigInteger('PermissionType');

            $table->foreign('PermissionType')->references('ID')->on('public_permissions_types')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('public_permissions');
    }
};
