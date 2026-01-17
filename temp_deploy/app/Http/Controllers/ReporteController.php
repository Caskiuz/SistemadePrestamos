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
        $totalPrestamos = Prestamo::where('estado', 'activo')->sum('monto');
        $totalVentas = Venta::sum('monto');
        $totalCompras = Compra::sum('monto');
        $saldoCaja = CashFlow::sum(\DB::raw('CASE WHEN tipo_movimiento = "entrada" THEN monto ELSE -monto END'));
        
        return view('modules.reportes.summary', compact('totalPrestamos', 'totalVentas', 'totalCompras', 'saldoCaja'));
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
        $prestamos = Prestamo::with(['cliente', 'productos'])
            ->where('estado', 'activo')
            ->whereDate('fecha_vencimiento', '<', now())
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
        $apartados = Apartado::with(['cliente', 'producto'])
            ->where('estado', 'activo')
            ->orderBy('fecha_vencimiento', 'asc')
            ->get();
        
        return view('modules.reportes.apartados', compact('apartados'))->with('titulo', 'Apartados Vigentes');
    }

    public function apartadosVencidos()
    {
        $apartados = Apartado::with(['cliente', 'producto'])
            ->where('estado', 'vencido')
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