<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tarifas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo'); // porcentaje, fijo
            $table->decimal('valor', 8, 2);
            $table->string('aplicacion'); // prestamo, almacenamiento, mora, servicio
            $table->boolean('activa')->default(true);
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });

        Schema::create('comisiones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestamo_id')->constrained('prestamos');
            $table->foreignId('tarifa_id')->constrained('tarifas');
            $table->decimal('monto', 10, 2);
            $table->date('fecha_aplicacion');
            $table->string('concepto');
            $table->foreignId('usuario_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comisiones');
        Schema::dropIfExists('tarifas');
    }
};