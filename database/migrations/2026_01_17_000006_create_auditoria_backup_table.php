<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('auditoria', function (Blueprint $table) {
            $table->id();
            $table->string('tabla');
            $table->string('accion'); // create, update, delete
            $table->unsignedBigInteger('registro_id');
            $table->json('datos_anteriores')->nullable();
            $table->json('datos_nuevos')->nullable();
            $table->foreignId('usuario_id')->constrained('users');
            $table->string('ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });

        Schema::create('backups', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('ruta');
            $table->bigInteger('tamaño');
            $table->string('tipo'); // manual, automatico
            $table->string('estado'); // completado, fallido, en_proceso
            $table->datetime('fecha_backup');
            $table->foreignId('usuario_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('backups');
        Schema::dropIfExists('auditoria');
    }
};