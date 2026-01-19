<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subasta;
use App\Models\Oferta;
use App\Models\Prestamo;
use App\Models\Cliente;

class SubastaController extends Controller
{
    public function index()
    {
        $subastas = Subasta::with(['prestamo.cliente', 'ganador'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('modules.subastas.index', compact('subastas'));
    }

    public function create($prestamoId)
    {
        $prestamo = Prestamo::with('productos')->findOrFail($prestamoId);
        
        if ($prestamo->estado !== 'expirado') {
            return redirect()->back()->with('error', 'Solo se pueden subastar préstamos expirados');
        }

        return view('modules.subastas.create', compact('prestamo'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'prestamo_id' => 'required|exists:prestamos,id',
            'precio_base' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date|after:now',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'descripcion' => 'nullable|string'
        ]);

        $subasta = Subasta::create([
            ...$validated,
            'precio_actual' => $validated['precio_base'],
            'estado' => 'programada'
        ]);

        return redirect()->route('subastas.show', $subasta->id)
            ->with('success', 'Subasta creada exitosamente');
    }

    public function show($id)
    {
        $subasta = Subasta::with(['prestamo.productos', 'ofertas.cliente', 'ganador'])
            ->findOrFail($id);
            
        return view('modules.subastas.show', compact('subasta'));
    }

    public function ofertar(Request $request, $id)
    {
        $subasta = Subasta::findOrFail($id);
        
        if ($subasta->estado !== 'activa') {
            return redirect()->back()->with('error', 'La subasta no está activa');
        }

        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'monto' => 'required|numeric|min:' . ($subasta->precio_actual + 1)
        ]);

        Oferta::create([
            'subasta_id' => $subasta->id,
            'cliente_id' => $validated['cliente_id'],
            'monto' => $validated['monto'],
            'fecha_oferta' => now()
        ]);

        $subasta->update(['precio_actual' => $validated['monto']]);

        return redirect()->route('subastas.show', $subasta->id)
            ->with('success', 'Oferta registrada');
    }

    public function finalizar($id)
    {
        $subasta = Subasta::with('ofertas')->findOrFail($id);
        
        $mejorOferta = $subasta->ofertas()->orderBy('monto', 'desc')->first();
        
        if ($mejorOferta) {
            $subasta->update([
                'estado' => 'finalizada',
                'ganador_id' => $mejorOferta->cliente_id
            ]);
            
            // Registrar venta por subasta en flujo de caja
            \App\Models\CashFlow::create([
                'fecha' => now(),
                'usuario_id' => auth()->id(),
                'concepto' => 'Subasta - Venta',
                'detalles' => 'Subasta #' . $subasta->codigo . ' - Ganador: ' . $mejorOferta->cliente->nombre,
                'monto' => $mejorOferta->monto,
                'tipo_movimiento' => 'entrada',
                'branch_id' => $subasta->prestamo->almacen_id
            ]);
        } else {
            $subasta->update(['estado' => 'cancelada']);
        }

        return redirect()->route('subastas.show', $subasta->id)
            ->with('success', 'Subasta finalizada');
    }
}