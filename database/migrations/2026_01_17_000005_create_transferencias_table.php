<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transferencias', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->foreignId('almacen_origen_id')->constrained('almacenes');
            $table->foreignId('almacen_destino_id')->constrained('almacenes');
            $table->foreignId('producto_id')->constrained('productos');
            $table->string('motivo');
            $table->text('observaciones')->nullable();
            $table->string('estado')->default('pendiente'); // pendiente, en_transito, completada, cancelada
            $table->datetime('fecha_envio');
            $table->datetime('fecha_recepcion')->nullable();
            $table->foreignId('usuario_envia_id')->constrained('users');
            $table->foreignId('usuario_recibe_id')->nullable()->constrained('users');
            $table->timestamps();
        });

        Schema::create('consolidados_sucursal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('almacen_id')->constrained('almacenes');
            $table->date('fecha');
            $table->integer('prestamos_activos');
            $table->decimal('monto_prestamos_activos', 12, 2);
            $table->integer('prestamos_liquidados');
            $table->decimal('ingresos_intereses', 10, 2);
            $table->integer('productos_inventario');
            $table->decimal('valor_inventario', 12, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consolidados_sucursal');
        Schema::dropIfExists('transferencias');
    }
};