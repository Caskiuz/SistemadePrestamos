<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabla nombre_cuentas
        Schema::create('nombre_cuentas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_cuenta');
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });

        // Tabla egresos
        Schema::create('egresos', function (Blueprint $table) {
            $table->id();
            $table->string('concepto');
            $table->decimal('monto', 12, 2);
            $table->date('fecha');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('egresos');
        Schema::dropIfExists('nombre_cuentas');
    }
};
