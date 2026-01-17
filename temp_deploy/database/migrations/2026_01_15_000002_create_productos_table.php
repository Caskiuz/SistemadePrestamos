<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo'); // electrodoméstico, vehículo, línea blanca, línea negra, joya, celular, etc
            $table->string('categoria')->nullable(); // oro, plata, electrodoméstico, etc
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('numero_serie')->nullable();
            $table->text('descripcion')->nullable();
            $table->decimal('peso', 10, 2)->nullable(); // para joyas
            $table->string('quilates')->nullable(); // para joyas
            $table->decimal('precio_compra', 12, 2)->nullable();
            $table->decimal('precio_venta', 12, 2)->nullable();
            $table->decimal('valuacion', 12, 2)->nullable();
            $table->decimal('avaluo', 12, 2)->nullable();
            $table->enum('estado', ['disponible', 'empeñado', 'vendido', 'apartado', 'en_venta'])->default('disponible');
            $table->unsignedBigInteger('almacen_id');
            $table->foreign('almacen_id')->references('id')->on('almacenes')->onDelete('cascade');
            $table->string('foto')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};