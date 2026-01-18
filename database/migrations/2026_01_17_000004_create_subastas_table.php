<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subastas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->foreignId('prestamo_id')->constrained('prestamos');
            $table->decimal('precio_base', 10, 2);
            $table->decimal('precio_actual', 10, 2)->default(0);
            $table->datetime('fecha_inicio');
            $table->datetime('fecha_fin');
            $table->string('estado')->default('programada'); // programada, activa, finalizada, cancelada
            $table->text('descripcion')->nullable();
            $table->foreignId('ganador_id')->nullable()->constrained('clientes');
            $table->timestamps();
        });

        Schema::create('ofertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subasta_id')->constrained('subastas');
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->decimal('monto', 10, 2);
            $table->datetime('fecha_oferta');
            $table->boolean('activa')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ofertas');
        Schema::dropIfExists('subastas');
    }
};