<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->unsignedBigInteger('almacen_id')->after('recepcion_id')->default(1);
            $table->foreign('almacen_id')->references('id')->on('almacenes')->onDelete('cascade');
            $table->decimal('monto', 12, 2)->nullable()->after('observaciones');
        });
    }

    public function down()
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->dropForeign(['almacen_id']);
            $table->dropColumn(['almacen_id', 'monto']);
        });
    }
};