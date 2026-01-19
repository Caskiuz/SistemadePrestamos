<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->enum('tipo_compra', ['venta_directa', 'liquidacion', 'adquisicion'])
                  ->default('venta_directa')
                  ->after('estado');
        });
    }

    public function down()
    {
        Schema::table('compras', function (Blueprint $table) {
            $table->dropColumn('tipo_compra');
        });
    }
};