<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notificaciones', function (Blueprint $table) {
            $table->id();
            $table->string('tipo'); // vencimiento, pago_pendiente, renovacion
            $table->string('titulo');
            $table->text('mensaje');
            $table->foreignId('prestamo_id')->constrained('prestamos');
            $table->foreignId('cliente_id')->constrained('clientes');
            $table->boolean('enviada')->default(false);
            $table->timestamp('fecha_envio')->nullable();
            $table->string('canal')->default('sistema'); // sistema, sms, whatsapp, email
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notificaciones');
    }
};