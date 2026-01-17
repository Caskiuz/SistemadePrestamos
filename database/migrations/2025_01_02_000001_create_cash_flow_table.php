<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cash_flow', function (Blueprint $table) {
            $table->id();
            $table->dateTime('fecha');
            $table->foreignId('usuario_id')->constrained('users');
            $table->string('concepto');
            $table->string('detalles')->nullable();
            $table->decimal('monto', 10, 2);
            $table->enum('tipo_movimiento', ['entrada', 'salida']);
            $table->foreignId('branch_id')->nullable()->constrained('almacenes');
            $table->timestamps();
            
            $table->index(['fecha', 'branch_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cash_flow');
    }
};
