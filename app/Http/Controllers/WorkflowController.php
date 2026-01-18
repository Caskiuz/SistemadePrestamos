<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Workflow;
use App\Models\Aprobacion;
use App\Models\Prestamo;

class WorkflowController extends Controller
{
    public function index()
    {
        $workflows = Workflow::orderBy('nombre')->get();
        return view('modules.workflow.index', compact('workflows'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string',
            'pasos' => 'required|array',
            'descripcion' => 'nullable|string'
        ]);

        Workflow::create($validated);
        return redirect()->route('workflows.index')->with('success', 'Workflow creado');
    }

    public function solicitarAprobacion(Request $request, $tipo, $id)
    {
        $workflow = Workflow::where('tipo', $tipo)->where('activo', true)->first();
        
        if (!$workflow) {
            return redirect()->back()->with('error', 'No hay workflow configurado');
        }

        Aprobacion::create([
            'tipo_documento' => $tipo,
            'documento_id' => $id,
            'workflow_id' => $workflow->id,
            'paso_actual' => 1,
            'estado' => 'pendiente',
            'usuario_solicitante_id' => auth()->id(),
            'fecha_solicitud' => now()
        ]);

        return redirect()->back()->with('success', 'Solicitud de aprobación enviada');
    }

    public function aprobar(Request $request, $id)
    {
        $aprobacion = Aprobacion::findOrFail($id);
        
        $validated = $request->validate([
            'accion' => 'required|in:aprobar,rechazar',
            'comentarios' => 'nullable|string'
        ]);

        $aprobacion->update([
            'estado' => $validated['accion'] === 'aprobar' ? 'aprobado' : 'rechazado',
            'usuario_aprobador_id' => auth()->id(),
            'comentarios' => $validated['comentarios'],
            'fecha_aprobacion' => now()
        ]);

        // Si es aprobado y es préstamo, activar
        if ($validated['accion'] === 'aprobar' && $aprobacion->tipo_documento === 'prestamo') {
            $prestamo = Prestamo::find($aprobacion->documento_id);
            $prestamo->update(['estado' => 'activo']);
        }

        return redirect()->back()->with('success', 'Aprobación procesada');
    }

    public function pendientes()
    {
        $aprobaciones = Aprobacion::where('estado', 'pendiente')
            ->with(['workflow', 'usuarioSolicitante'])
            ->orderBy('fecha_solicitud', 'desc')
            ->paginate(15);
            
        return view('modules.workflow.pendientes', compact('aprobaciones'));
    }
}