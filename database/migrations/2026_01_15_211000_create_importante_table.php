<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('importante', function (Blueprint $table) {
            $table->id('id_importante');
            $table->string('importante');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('importante');
    }
};
