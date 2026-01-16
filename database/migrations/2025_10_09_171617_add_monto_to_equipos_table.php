<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar los cambios en la base de datos.
     */
    public function up(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            // Agregamos la columna 'monto' de tipo decimal (10 dígitos, 2 decimales)
            $table->decimal('monto', 10, 2)->default(0)->after('potencia_unidad');
        });
    }

    /**
     * Revertir los cambios (rollback).
     */
    public function down(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->dropColumn('monto');
        });
    }
};
