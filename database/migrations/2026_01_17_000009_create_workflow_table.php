<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('workflows', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo'); // prestamo, venta, compra
            $table->json('pasos');
            $table->boolean('activo')->default(true);
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });

        Schema::create('aprobaciones', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_documento'); // prestamo, venta, etc
            $table->unsignedBigInteger('documento_id');
            $table->foreignId('workflow_id')->constrained('workflows');
            $table->integer('paso_actual');
            $table->string('estado'); // pendiente, aprobado, rechazado
            $table->foreignId('usuario_solicitante_id')->constrained('users');
            $table->foreignId('usuario_aprobador_id')->nullable()->constrained('users');
            $table->text('comentarios')->nullable();
            $table->datetime('fecha_solicitud');
            $table->datetime('fecha_aprobacion')->nullable();
            $table->timestamps();
        });

        Schema::create('estados_prestamo_workflow', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion');
            $table->string('color')->default('#007bff');
            $table->boolean('es_final')->default(false);
            $table->json('transiciones_permitidas')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('estados_prestamo_workflow');
        Schema::dropIfExists('aprobaciones');
        Schema::dropIfExists('workflows');
    }
};