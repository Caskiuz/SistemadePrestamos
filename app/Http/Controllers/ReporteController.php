<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;
use App\Models\Venta;
use App\Models\Compra;
use App\Models\Apartado;
use App\Models\Cliente;
use App\Models\CashFlow;

class ReporteController extends Controller
{
    public function index()
    {
        return view('modules.reportes.index');
    }

    public function summary()
    {
        try {
            // Datos de caja
            $totalCaja = CashFlow::sum(\DB::raw('CASE WHEN tipo_movimiento = "entrada" THEN monto ELSE -monto END')) ?? 0;
            $ingresosDia = CashFlow::where('tipo_movimiento', 'entrada')
                ->whereDate('fecha', today())
                ->sum('monto') ?? 0;
            $egresosDia = CashFlow::where('tipo_movimiento', 'salida')
                ->whereDate('fecha', today())
                ->sum('monto') ?? 0;
            
            // Datos de préstamos
            $prestamosActivos = Prestamo::where('estado', 'activo')->count();
            $prestamosVencidos = Prestamo::where('estado', 'vencido')->count();
            $totalPrestado = Prestamo::whereIn('estado', ['activo', 'vencido'])->sum('monto') ?? 0;
            
            // Datos de inventario
            $prendasEmpenadas = \DB::table('prestamo_producto')
                ->join('prestamos', 'prestamo_producto.prestamo_id', '=', 'prestamos.id')
                ->whereIn('prestamos.estado', ['activo', 'vencido'])
                ->count();
            $prendasVenta = \DB::table('productos')
                ->where('estado', 'forSale')
                ->count();
            $valorInventario = \DB::table('productos')
                ->whereIn('estado', ['forSale', 'loan'])
                ->sum('valuacion') ?? 0;
            
            return view('modules.reportes.summary', compact(
                'totalCaja', 'ingresosDia', 'egresosDia',
                'prestamosActivos', 'prestamosVencidos', 'totalPrestado',
                'prendasEmpenadas', 'prendasVenta', 'valorInventario'
            ));
        } catch (\Exception $e) {
            \Log::error('Error en reportes/summary: ' . $e->getMessage());
            
            // Valores por defecto en caso de error
            return view('modules.reportes.summary', [
                'totalCaja' => 0,
                'ingresosDia' => 0,
                'egresosDia' => 0,
                'prestamosActivos' => 0,
                'prestamosVencidos' => 0,
                'totalPrestado' => 0,
                'prendasEmpenadas' => 0,
                'prendasVenta' => 0,
                'valorInventario' => 0
            ]);
        }
    }

    public function prestamosVigentes()
    {
        $prestamos = Prestamo::with(['cliente', 'productos'])
            ->where('estado', 'activo')
            ->whereDate('fecha_vencimiento', '>', now())
            ->orderBy('fecha_vencimiento', 'asc')
            ->get();
        
        return view('modules.reportes.prestamos', compact('prestamos'))->with('titulo', 'Préstamos Vigentes');
    }

    public function prestamosPorVencer()
    {
        $prestamos = Prestamo::with(['cliente', 'productos'])
            ->where('estado', 'activo')
            ->whereDate('fecha_vencimiento', '<=', now()->addDays(7))
            ->whereDate('fecha_vencimiento', '>=', now())
            ->orderBy('fecha_vencimiento', 'asc')
            ->get();
        
        return view('modules.reportes.prestamos', compact('prestamos'))->with('titulo', 'Préstamos por Vencer');
    }

    public function prestamosVencidos()
    {
        // Solo actualizar si es necesario (optimizado)
        $needsUpdate = Prestamo::where('estado', 'activo')
            ->whereDate('fecha_vencimiento', '<', now())
            ->exists();
            
        if ($needsUpdate) {
            Prestamo::where('estado', 'activo')
                ->whereDate('fecha_vencimiento', '<', now())
                ->update(['estado' => 'vencido']);
        }
            
        $prestamos = Prestamo::with(['cliente', 'productos'])
            ->where('estado', 'vencido')
            ->orderBy('fecha_vencimiento', 'desc')
            ->get();
        
        return view('modules.reportes.prestamos', compact('prestamos'))->with('titulo', 'Préstamos Vencidos');
    }

    public function prestamosExpirados()
    {
        $prestamos = Prestamo::with(['cliente', 'productos'])
            ->where('estado', 'expirado')
            ->orderBy('fecha_vencimiento', 'desc')
            ->get();
        
        return view('modules.reportes.prestamos', compact('prestamos'))->with('titulo', 'Préstamos Expirados');
    }

    public function prestamosLiquidados()
    {
        $prestamos = Prestamo::with(['cliente', 'productos'])
            ->where('estado', 'liquidado')
            ->orderBy('updated_at', 'desc')
            ->get();
        
        return view('modules.reportes.prestamos', compact('prestamos'))->with('titulo', 'Préstamos Liquidados');
    }

    public function apartadosVigentes()
    {
        // Actualizar apartados vencidos
        Apartado::where('estado', 'VIGENTE')
            ->whereDate('fecha_vencimiento', '<', now())
            ->update(['estado' => 'VENCIDO']);
            
        $apartados = Apartado::with(['cliente', 'producto', 'almacen'])
            ->where('estado', 'VIGENTE')
            ->orderBy('fecha_vencimiento', 'asc')
            ->get();
        
        return view('modules.reportes.apartados', compact('apartados'))->with('titulo', 'Apartados Vigentes');
    }

    public function apartadosVencidos()
    {
        // Actualizar apartados vencidos
        Apartado::where('estado', 'VIGENTE')
            ->whereDate('fecha_vencimiento', '<', now())
            ->update(['estado' => 'VENCIDO']);
            
        $apartados = Apartado::with(['cliente', 'producto', 'almacen'])
            ->where('estado', 'VENCIDO')
            ->orderBy('fecha_vencimiento', 'desc')
            ->get();
        
        return view('modules.reportes.apartados', compact('apartados'))->with('titulo', 'Apartados Vencidos');
    }

    public function excel(Request $request)
    {
        $prestamos = Prestamo::with(['cliente', 'productos'])->get();
        $ventas = Venta::with(['cliente', 'producto'])->get();
        $compras = Compra::with(['cliente', 'producto'])->get();
        $apartados = Apartado::with(['cliente', 'producto'])->get();
        $clientes = Cliente::all();

        $csv = "Tipo,Fecha,Cliente,Descripción,Monto\n";
        
        foreach ($prestamos as $p) {
            $csv .= "Préstamo,{$p->fecha_prestamo},{$p->cliente->nombre},Folio {$p->folio},{$p->monto}\n";
        }
        
        foreach ($ventas as $v) {
            $csv .= "Venta,{$v->fecha_venta},{$v->cliente->nombre},{$v->producto->nombre},{$v->monto}\n";
        }
        
        foreach ($compras as $c) {
            $csv .= "Compra,{$c->fecha_compra},{$c->cliente->nombre},{$c->producto->nombre},{$c->monto}\n";
        }

        return response($csv, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="respaldo_' . date('Y-m-d') . '.csv"');
    }

    public function registrarMovimiento(Request $request)
    {
        $validated = $request->validate([
            'monto' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'tipo' => 'required|in:deposito,retiro,gasto'
        ]);

        $conceptos = [
            'deposito' => 'Depósito',
            'retiro' => 'Retiro',
            'gasto' => 'Gasto'
        ];

        $tipoMovimiento = $validated['tipo'] === 'deposito' ? 'entrada' : 'salida';

        CashFlow::create([
            'fecha' => now(),
            'usuario_id' => auth()->id(),
            'concepto' => $conceptos[$validated['tipo']],
            'detalles' => $validated['descripcion'] ?? '',
            'monto' => $validated['monto'],
            'tipo_movimiento' => $tipoMovimiento,
            'branch_id' => auth()->user()->almacen_id ?? 1
        ]);

        return response()->json([
            'success' => true,
            'message' => $conceptos[$validated['tipo']] . ' registrado exitosamente'
        ]);
    }
}