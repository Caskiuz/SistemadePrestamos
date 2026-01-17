<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('apartados', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->foreignId('almacen_id')->constrained('almacenes')->onDelete('cascade');
            $table->decimal('anticipo', 12, 2);
            $table->decimal('monto_total', 12, 2);
            $table->date('fecha_apartado');
            $table->date('fecha_vencimiento');
            $table->enum('estado', ['VIGENTE', 'VENCIDO', 'CANCELADO', 'COMPLETADO'])->default('VIGENTE');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('apartados');
    }
};
