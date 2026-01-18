<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\Cliente;
use App\Models\CashFlow;
use App\Models\Pago;
use Carbon\Carbon;

class ReporteAvanzadoController extends Controller
{
    public function rentabilidad(Request $request)
    {
        $fechaInicio = $request->fecha_inicio ?? Carbon::now()->startOfMonth();
        $fechaFin = $request->fecha_fin ?? Carbon::now()->endOfMonth();

        $ingresos = Pago::whereBetween('fecha_pago', [$fechaInicio, $fechaFin])
            ->sum('interes_pagado');
            
        $prestamosOtorgados = Prestamo::whereBetween('fecha_prestamo', [$fechaInicio, $fechaFin])
            ->sum('monto');
            
        $rentabilidad = $prestamosOtorgados > 0 ? ($ingresos / $prestamosOtorgados) * 100 : 0;

        $data = [
            'ingresos_intereses' => $ingresos,
            'prestamos_otorgados' => $prestamosOtorgados,
            'rentabilidad_porcentaje' => round($rentabilidad, 2),
            'periodo' => [
                'inicio' => $fechaInicio,
                'fin' => $fechaFin
            ]
        ];

        return view('modules.reportes.rentabilidad', compact('data'));
    }

    public function riesgoCrediticio()
    {
        $clientes = Cliente::withCount([
            'prestamos',
            'prestamos as prestamos_activos' => function($q) {
                $q->where('estado', 'activo');
            },
            'prestamos as prestamos_vencidos' => function($q) {
                $q->where('estado', 'activo')->where('fecha_vencimiento', '<', now());
            },
            'prestamos as prestamos_liquidados' => function($q) {
                $q->where('estado', 'liquidado');
            }
        ])->having('prestamos_count', '>', 0)->get();

        $clientesRiesgo = $clientes->map(function($cliente) {
            $totalPrestamos = $cliente->prestamos_count;
            $vencidos = $cliente->prestamos_vencidos;
            $liquidados = $cliente->prestamos_liquidados;
            
            $porcentajeVencimiento = $totalPrestamos > 0 ? ($vencidos / $totalPrestamos) * 100 : 0;
            $porcentajeLiquidacion = $totalPrestamos > 0 ? ($liquidados / $totalPrestamos) * 100 : 0;
            
            $riesgo = 'BAJO';
            if ($porcentajeVencimiento > 50) $riesgo = 'ALTO';
            elseif ($porcentajeVencimiento > 25) $riesgo = 'MEDIO';
            
            return [
                'cliente' => $cliente,
                'total_prestamos' => $totalPrestamos,
                'vencidos' => $vencidos,
                'liquidados' => $liquidados,
                'porcentaje_vencimiento' => round($porcentajeVencimiento, 2),
                'porcentaje_liquidacion' => round($porcentajeLiquidacion, 2),
                'nivel_riesgo' => $riesgo
            ];
        })->sortByDesc('porcentaje_vencimiento');

        return view('modules.reportes.riesgo-crediticio', compact('clientesRiesgo'));
    }

    public function estadisticasRecuperacion()
    {
        $prestamosLiquidados = Prestamo::where('estado', 'liquidado')->count();
        $prestamosExpirados = Prestamo::where('estado', 'expirado')->count();
        $prestamosActivos = Prestamo::where('estado', 'activo')->count();
        $totalPrestamos = $prestamosLiquidados + $prestamosExpirados + $prestamosActivos;

        $tasaRecuperacion = $totalPrestamos > 0 ? ($prestamosLiquidados / $totalPrestamos) * 100 : 0;
        $tasaExpiracion = $totalPrestamos > 0 ? ($prestamosExpirados / $totalPrestamos) * 100 : 0;

        $tiempoPromedioLiquidacion = Prestamo::where('estado', 'liquidado')
            ->selectRaw('AVG(DATEDIFF(updated_at, fecha_prestamo)) as promedio')
            ->first()->promedio ?? 0;

        $data = [
            'total_prestamos' => $totalPrestamos,
            'liquidados' => $prestamosLiquidados,
            'expirados' => $prestamosExpirados,
            'activos' => $prestamosActivos,
            'tasa_recuperacion' => round($tasaRecuperacion, 2),
            'tasa_expiracion' => round($tasaExpiracion, 2),
            'tiempo_promedio_liquidacion' => round($tiempoPromedioLiquidacion, 0)
        ];

        return view('modules.reportes.recuperacion', compact('data'));
    }

    public function flujoEfectivo(Request $request)
    {
        $fechaInicio = $request->fecha_inicio ?? Carbon::now()->startOfMonth();
        $fechaFin = $request->fecha_fin ?? Carbon::now()->endOfMonth();

        $movimientos = CashFlow::whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->orderBy('fecha', 'desc')
            ->get();

        $ingresos = $movimientos->where('tipo_movimiento', 'entrada')->sum('monto');
        $egresos = $movimientos->where('tipo_movimiento', 'salida')->sum('monto');
        $flujoNeto = $ingresos - $egresos;

        $data = [
            'movimientos' => $movimientos,
            'ingresos' => $ingresos,
            'egresos' => $egresos,
            'flujo_neto' => $flujoNeto,
            'periodo' => [
                'inicio' => $fechaInicio,
                'fin' => $fechaFin
            ]
        ];

        return view('modules.reportes.flujo-efectivo', compact('data'));
    }
}