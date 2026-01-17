<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->foreignId('almacen_id')->constrained('almacenes')->onDelete('cascade');
            $table->decimal('monto', 12, 2);
            $table->date('fecha_compra');
            $table->enum('estado', ['PENDIENTE', 'COMPLETADA', 'CANCELADA'])->default('PENDIENTE');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('compras');
    }
};
