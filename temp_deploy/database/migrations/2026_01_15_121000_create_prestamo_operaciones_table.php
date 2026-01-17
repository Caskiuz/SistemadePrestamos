<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestamo_operaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestamo_id')->constrained('prestamos')->onDelete('cascade');
            $table->enum('tipo', ['prestamo', 'interes_generado', 'pago', 'descuento', 'cancelacion', 'reversion']);
            $table->decimal('cargo', 10, 2)->default(0);
            $table->decimal('abono', 10, 2)->default(0);
            $table->decimal('saldo', 10, 2);
            $table->foreignId('usuario_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestamo_operaciones');
    }
};
