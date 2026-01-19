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
        Schema::table('fotos_equipos', function (Blueprint $table) {
            $table->dropForeign(['equipo_id']);
            $table->unsignedBigInteger('equipo_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fotos_equipos', function (Blueprint $table) {
            $table->unsignedBigInteger('equipo_id')->nullable(false)->change();
            $table->foreign('equipo_id')->references('id')->on('equipos');
        });
    }
};
