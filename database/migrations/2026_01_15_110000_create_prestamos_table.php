<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('almacen_id')->constrained('almacenes')->onDelete('cascade');
            $table->foreignId('interes_id')->nullable()->constrained('intereses')->onDelete('set null');
            $table->decimal('monto', 12, 2);
            $table->decimal('interes_mensual', 5, 2)->default(0);
            $table->decimal('monto_total', 12, 2);
            $table->decimal('monto_pagado', 12, 2)->default(0);
            $table->decimal('monto_pendiente', 12, 2);
            $table->date('fecha_prestamo');
            $table->date('fecha_vencimiento');
            $table->integer('plazo_dias')->default(30);
            $table->enum('estado', ['activo', 'liquidado', 'vencido', 'expirado', 'cancelado'])->default('activo');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('prestamos');
    }
};
