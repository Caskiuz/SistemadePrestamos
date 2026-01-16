<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;
use Illuminate\Support\Facades\Hash;

class EmpleadoController extends Controller
{
    public function index() {
        $empleados = Empleado::orderBy('nombre')->get();
        return view('modules.empleados.index', compact('empleados'));
    }

    public function create() {
        return view('modules.empleados.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:empleados',
            'rol' => 'required|in:Empleado,Supervisor,Gerente,Administrador',
            'password' => 'required|min:6',
        ]);

        $empleado = Empleado::create([
            'nombre' => $validated['nombre'],
            'email' => $validated['email'],
            'rol' => $validated['rol'],
            'password' => Hash::make($validated['password']),
            'activo' => true,
        ]);

        return redirect()->route('configuracion.empleados')
            ->with('success', 'Empleado registrado exitosamente');
    }

    public function show($id) {
        $empleado = Empleado::findOrFail($id);
        return view('modules.empleados.show', compact('empleado'));
    }

    public function update(Request $request, $id) {
        $empleado = Empleado::findOrFail($id);
        $empleado->update($request->all());
        return redirect()->route('configuracion.empleados')
            ->with('success', 'Empleado actualizado exitosamente');
    }

    public function destroy($id) {
        Empleado::destroy($id);
        return redirect()->route('configuracion.empleados')
            ->with('success', 'Empleado eliminado exitosamente');
    }
}
