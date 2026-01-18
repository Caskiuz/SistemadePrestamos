<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('verificaciones_externas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->string('tipo'); // identidad, centrales_riesgo, antecedentes
            $table->string('servicio'); // reniec, sbs, pnp, etc
            $table->json('datos_enviados');
            $table->json('respuesta')->nullable();
            $table->string('estado'); // pendiente, exitoso, fallido
            $table->string('resultado')->nullable(); // aprobado, rechazado, observado
            $table->text('observaciones')->nullable();
            $table->datetime('fecha_consulta');
            $table->timestamps();
        });

        Schema::create('integraciones_bancarias', function (Blueprint $table) {
            $table->id();
            $table->string('banco');
            $table->string('tipo_operacion'); // deposito, retiro, transferencia
            $table->string('numero_operacion');
            $table->decimal('monto', 10, 2);
            $table->string('estado'); // pendiente, procesado, fallido
            $table->json('datos_transaccion');
            $table->datetime('fecha_operacion');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('integraciones_bancarias');
        Schema::dropIfExists('verificaciones_externas');
    }
};