<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Configuracion;

return new class extends Migration
{
    public function up()
    {
        // Actualizar configuraciones existentes para Bolivia
        $configuraciones = [
            ['clave' => 'empresa_direccion', 'valor' => 'Santa Ana, Bolivia', 'categoria' => 'empresa'],
            ['clave' => 'empresa_telefono', 'valor' => '+591 2-000-0000', 'categoria' => 'empresa'],
            ['clave' => 'sistema_zona_horaria', 'valor' => 'America/La_Paz', 'categoria' => 'sistema'],
            ['clave' => 'sistema_moneda', 'valor' => 'BOB', 'categoria' => 'sistema'],
        ];

        foreach ($configuraciones as $config) {
            Configuracion::updateOrCreate(
                ['clave' => $config['clave']],
                $config
            );
        }

        // Agregar nuevas configuraciones específicas de Bolivia
        $nuevasConfiguraciones = [
            ['clave' => 'empresa_nit', 'valor' => '1234567890', 'categoria' => 'empresa', 'descripcion' => 'NIT de la empresa'],
            ['clave' => 'empresa_pais', 'valor' => 'Bolivia', 'categoria' => 'empresa', 'descripcion' => 'País de operación'],
            ['clave' => 'sistema_moneda_simbolo', 'valor' => 'Bs.', 'categoria' => 'sistema', 'descripcion' => 'Símbolo de la moneda'],
            ['clave' => 'sistema_pais', 'valor' => 'Bolivia', 'categoria' => 'sistema', 'descripcion' => 'País del sistema'],
        ];

        foreach ($nuevasConfiguraciones as $config) {
            Configuracion::updateOrCreate(
                ['clave' => $config['clave']],
                $config
            );
        }
    }

    public function down()
    {
        // Revertir a configuraciones genéricas
        $configuraciones = [
            'empresa_direccion' => 'Dirección Principal',
            'empresa_telefono' => '+000 000-000-0000',
            'sistema_zona_horaria' => 'UTC',
            'sistema_moneda' => 'USD',
            'sistema_moneda_simbolo' => '$',
        ];

        foreach ($configuraciones as $clave => $valor) {
            Configuracion::where('clave', $clave)->update(['valor' => $valor]);
        }

        // Eliminar configuraciones específicas de Bolivia
        Configuracion::whereIn('clave', [
            'empresa_nit',
            'empresa_pais',
            'sistema_pais'
        ])->delete();
    }
};