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
        Schema::create('who_can_see_events', function (Blueprint $table) {
            $table->unsignedBigInteger('RoleTypeID');
            $table->unsignedBigInteger('CalendaerEventID');

            $table->foreign('RoleTypeID')->references('ID')->on('role_types')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('CalendaerEventID')->references('ID')->on('calendar_events')->onDelete('cascade')->onUpdate('cascade');
            $table->unique(['RoleTypeID', 'CalendaerEventID'])->primary();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('who_can_see_events');
    }
};
