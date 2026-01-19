<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function index(Request $request) {
        $query = Cliente::query();

        // Filtro por orden alfabético
        if ($request->sort === 'az') {
            $query->orderBy('nombre', 'asc');
        }

        // Filtro por puntuación
        if ($request->sort === 'score') {
            $query->orderBy('created_at', 'desc');
        }

        // Filtro por cumpleaños - deshabilitado (columna no existe)
        if ($request->filter === 'birthday') {
            // $query->whereMonth('fecha_nacimiento', now()->month);
            // Por ahora no filtrar por cumpleaños hasta agregar la columna
        }

        // Filtro por inactividad
        if ($request->filter === 'inactive') {
            $query->whereDoesntHave('prestamos', function($q) {
                $q->where('created_at', '>', now()->subMonths(6));
            });
        }

        // Búsqueda general
        if ($request->q) {
            $query->where(function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->q . '%')
                  ->orWhere('telefono_1', 'like', '%' . $request->q . '%')
                  ->orWhere('direccion', 'like', '%' . $request->q . '%');
            });
        }

        $clientes = $query->paginate(10);
        // Usar la vista principal de clientes
        return view('modules.clientes.yo-presto.index', compact('clientes'));
    }

    public function create() {
        return view('modules.clientes.create');
    }

    public function store(Request $request) {
        $data = $request->all();
        
        // Validar y asignar valores por defecto
        if (empty($data['tipo'])) {
            $data['tipo'] = 'PERSONA';
        }
        
        if (empty($data['tipo_documento'])) {
            $data['tipo_documento'] = 'CI';
        }
        
        // Asegurar que tipo_documento sea válido
        $tiposValidos = ['CI', 'NIT', 'PASAPORTE', 'OTRO'];
        if (!in_array($data['tipo_documento'], $tiposValidos)) {
            $data['tipo_documento'] = 'CI';
        }
        
        if (empty($data['numero_documento'])) {
            $data['numero_documento'] = 'S/N-' . time();
        }
        
        // Asegurar que todos los campos requeridos tengan valores
        $data['telefono_1'] = $data['telefono_1'] ?? '';
        $data['telefono_2'] = $data['telefono_2'] ?? '';
        $data['telefono_3'] = $data['telefono_3'] ?? '';
        $data['direccion'] = $data['direccion'] ?? '';
        $data['email'] = $data['email'] ?? '';
        $data['ciudad'] = $data['ciudad'] ?? 'Santa Cruz';
        
        $cliente = Cliente::create($data);
        
        // Si es petición AJAX, retornar JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'cliente' => $cliente,
                'message' => 'Cliente creado exitosamente'
            ]);
        }
        
        return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente');
    }

    public function show($id) {
        $cliente = Cliente::with(['prestamos' => function($q) {
            $q->orderBy('created_at', 'desc');
        }])->findOrFail($id);
        return view('modules.clientes.show', compact('cliente'));
    }

    public function edit($id) {
        $cliente = Cliente::findOrFail($id);
        return view('modules.clientes.edit', compact('cliente'));
    }

    public function update(Request $request, $id) {
        $cliente = Cliente::findOrFail($id);
        $data = $request->all();
        
        // Validar y limpiar datos
        if (empty($data['tipo'])) {
            $data['tipo'] = 'PERSONA';
        }
        
        if (empty($data['tipo_documento'])) {
            $data['tipo_documento'] = 'CI';
        }
        
        // Asegurar que tipo_documento sea válido
        $tiposValidos = ['CI', 'NIT', 'PASAPORTE', 'OTRO'];
        if (!in_array($data['tipo_documento'], $tiposValidos)) {
            $data['tipo_documento'] = 'CI';
        }
        
        if (empty($data['numero_documento'])) {
            $data['numero_documento'] = 'S/N-' . time();
        }
        
        $cliente->update($data);
        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente');
    }

    public function destroy($id) {
        Cliente::destroy($id);
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente');
    }
}
