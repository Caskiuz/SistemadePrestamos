<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('prestamos', function (Blueprint $table) {
            $table->enum('estado', ['activo', 'vencido', 'expirado', 'liquidado', 'cancelado'])->default('activo')->change();
        });
    }

    public function down()
    {
        Schema::table('prestamos', function (Blueprint $table) {
            $table->enum('estado', ['activo', 'liquidado', 'vencido', 'expirado', 'cancelado'])->default('activo')->change();
        });
    }
};