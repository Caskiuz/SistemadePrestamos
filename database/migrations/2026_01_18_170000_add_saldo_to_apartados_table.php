<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('apartados', function (Blueprint $table) {
            $table->decimal('saldo', 12, 2)->after('monto_total')->default(0);
        });
    }

    public function down()
    {
        Schema::table('apartados', function (Blueprint $table) {
            $table->dropColumn('saldo');
        });
    }
};