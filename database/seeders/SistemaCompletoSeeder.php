<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tarifa;
use App\Models\Workflow;
use App\Models\EstadoPrestamoWorkflow;

class SistemaCompletoSeeder extends Seeder
{
    public function run()
    {
        // Tarifas básicas
        Tarifa::create([
            'nombre' => 'Comisión por Préstamo',
            'tipo' => 'porcentaje',
            'valor' => 2.5,
            'aplicacion' => 'prestamo',
            'descripcion' => 'Comisión del 2.5% sobre el monto del préstamo'
        ]);

        Tarifa::create([
            'nombre' => 'Tarifa de Almacenamiento',
            'tipo' => 'fijo',
            'valor' => 10.00,
            'aplicacion' => 'almacenamiento',
            'descripcion' => 'Tarifa fija mensual por almacenamiento'
        ]);

        Tarifa::create([
            'nombre' => 'Penalización por Mora',
            'tipo' => 'porcentaje',
            'valor' => 5.0,
            'aplicacion' => 'mora',
            'descripcion' => 'Penalización del 5% por mora'
        ]);

        // Workflow básico para préstamos
        Workflow::create([
            'nombre' => 'Aprobación de Préstamos',
            'tipo' => 'prestamo',
            'pasos' => [
                ['paso' => 1, 'nombre' => 'Evaluación Inicial', 'rol_requerido' => 'Evaluador'],
                ['paso' => 2, 'nombre' => 'Aprobación Gerencial', 'rol_requerido' => 'Gerente']
            ],
            'descripcion' => 'Workflow estándar para aprobación de préstamos'
        ]);

        // Estados de préstamo para workflow
        $estados = [
            ['nombre' => 'Borrador', 'descripcion' => 'Préstamo en preparación', 'color' => '#6c757d'],
            ['nombre' => 'Pendiente Aprobación', 'descripcion' => 'Esperando aprobación', 'color' => '#ffc107'],
            ['nombre' => 'Activo', 'descripcion' => 'Préstamo activo', 'color' => '#28a745'],
            ['nombre' => 'Vencido', 'descripcion' => 'Préstamo vencido', 'color' => '#fd7e14'],
            ['nombre' => 'Liquidado', 'descripcion' => 'Préstamo liquidado', 'color' => '#007bff', 'es_final' => true],
            ['nombre' => 'Expirado', 'descripcion' => 'Préstamo expirado', 'color' => '#dc3545', 'es_final' => true],
            ['nombre' => 'Renovado', 'descripcion' => 'Préstamo renovado', 'color' => '#17a2b8', 'es_final' => true]
        ];

        foreach ($estados as $estado) {
            EstadoPrestamoWorkflow::create($estado);
        }
    }
}