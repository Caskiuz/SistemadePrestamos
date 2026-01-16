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

        // Filtro por cumpleaños
        if ($request->filter === 'birthday') {
            $query->whereMonth('fecha_nacimiento', now()->month);
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
        // Usar la nueva vista Blade adaptada
        return view('modules.clientes.yo-presto.index', compact('clientes'));
    }

    public function create() {
        return view('modules.clientes.create');
    }

    public function store(Request $request) {
        $data = $request->all();
        if (empty($data['tipo_documento'])) {
            $data['tipo_documento'] = 'CI';
        }
        if (empty($data['numero_documento'])) {
            $data['numero_documento'] = 'S/N';
        }
        $cliente = Cliente::create($data);
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
        if (empty($data['tipo_documento'])) {
            $data['tipo_documento'] = 'CI';
        }
        $cliente->update($data);
        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente');
    }

    public function destroy($id) {
        Cliente::destroy($id);
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado exitosamente');
    }
}
