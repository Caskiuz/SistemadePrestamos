<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('intereses', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('porcentaje', 5, 2)->default(10.00); // máximo 10%
            $table->text('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('intereses');
    }
};
