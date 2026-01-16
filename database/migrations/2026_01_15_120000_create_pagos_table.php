<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestamo_id')->constrained('prestamos')->onDelete('cascade');
            $table->enum('tipo', ['refrendo', 'abono_capital', 'liquidacion']);
            $table->decimal('monto', 10, 2);
            $table->decimal('interes_pagado', 10, 2)->default(0);
            $table->decimal('capital_pagado', 10, 2)->default(0);
            $table->date('fecha_pago');
            $table->foreignId('usuario_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
