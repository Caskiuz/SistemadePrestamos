<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('renovaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestamo_original_id')->constrained('prestamos');
            $table->foreignId('prestamo_nuevo_id')->constrained('prestamos');
            $table->decimal('monto_renovado', 10, 2);
            $table->decimal('intereses_pagados', 10, 2);
            $table->date('fecha_renovacion');
            $table->integer('dias_extension');
            $table->text('observaciones')->nullable();
            $table->foreignId('usuario_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('renovaciones');
    }
};