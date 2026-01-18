<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('avales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestamo_id')->constrained('prestamos');
            $table->foreignId('cliente_aval_id')->constrained('clientes');
            $table->string('tipo_aval'); // solidario, simple, mancomunado
            $table->decimal('monto_garantizado', 10, 2);
            $table->string('estado')->default('activo'); // activo, liberado, ejecutado
            $table->text('observaciones')->nullable();
            $table->date('fecha_constitucion');
            $table->date('fecha_vencimiento')->nullable();
            $table->timestamps();
        });

        Schema::create('seguros_prendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestamo_id')->constrained('prestamos');
            $table->string('aseguradora');
            $table->string('numero_poliza');
            $table->decimal('valor_asegurado', 10, 2);
            $table->decimal('prima', 8, 2);
            $table->date('fecha_inicio');
            $table->date('fecha_vencimiento');
            $table->string('estado')->default('vigente'); // vigente, vencido, cancelado
            $table->text('cobertura')->nullable();
            $table->timestamps();
        });

        Schema::create('garantias_cruzadas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestamo_principal_id')->constrained('prestamos');
            $table->foreignId('prestamo_garantia_id')->constrained('prestamos');
            $table->decimal('porcentaje_garantia', 5, 2);
            $table->string('estado')->default('activa');
            $table->text('condiciones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('garantias_cruzadas');
        Schema::dropIfExists('seguros_prendas');
        Schema::dropIfExists('avales');
    }
};