<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Configuracion;

class ConfigurarBolivia extends Command
{
    protected $signature = 'bolivia:configurar';
    protected $description = 'Configura el sistema para Bolivia con Bolivianos como moneda';

    public function handle()
    {
        $this->info('Configurando sistema para Bolivia...');

        // Configuraciones específicas de Bolivia
        $configuraciones = [
            ['clave' => 'empresa_pais', 'valor' => 'Bolivia', 'categoria' => 'empresa', 'descripcion' => 'País de la empresa'],
            ['clave' => 'empresa_direccion', 'valor' => 'Santa Ana, Bolivia', 'categoria' => 'empresa', 'descripcion' => 'Dirección principal'],
            ['clave' => 'empresa_telefono', 'valor' => '+591 2-000-0000', 'categoria' => 'empresa', 'descripcion' => 'Teléfono principal'],
            ['clave' => 'sistema_zona_horaria', 'valor' => 'America/La_Paz', 'categoria' => 'sistema', 'descripcion' => 'Zona horaria del sistema'],
            ['clave' => 'sistema_moneda', 'valor' => 'BOB', 'categoria' => 'sistema', 'descripcion' => 'Moneda del sistema'],
            ['clave' => 'sistema_moneda_simbolo', 'valor' => 'Bs.', 'categoria' => 'sistema', 'descripcion' => 'Símbolo de la moneda'],
            ['clave' => 'sistema_pais', 'valor' => 'Bolivia', 'categoria' => 'sistema', 'descripcion' => 'País del sistema'],
        ];

        $this->info('Actualizando configuraciones...');
        $bar = $this->output->createProgressBar(count($configuraciones));

        foreach ($configuraciones as $config) {
            Configuracion::updateOrCreate(
                ['clave' => $config['clave']],
                $config
            );
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        // Agregar configuraciones adicionales si no existen
        $nuevasConfiguraciones = [
            ['clave' => 'empresa_nit', 'valor' => '1234567890', 'categoria' => 'empresa', 'descripcion' => 'NIT de la empresa'],
            ['clave' => 'sistema_moneda_simbolo', 'valor' => 'Bs.', 'categoria' => 'sistema', 'descripcion' => 'Símbolo de la moneda'],
        ];

        $this->info('Agregando configuraciones adicionales...');
        foreach ($nuevasConfiguraciones as $config) {
            Configuracion::updateOrCreate(
                ['clave' => $config['clave']],
                $config
            );
        }

        $this->info('✅ Sistema configurado exitosamente para Bolivia');
        $this->info('🇧🇴 País: Bolivia');
        $this->info('💰 Moneda: Bolivianos (Bs.)');
        $this->info('🕐 Zona horaria: America/La_Paz');
        $this->info('🌍 Locale: es_BO');

        return 0;
    }
}