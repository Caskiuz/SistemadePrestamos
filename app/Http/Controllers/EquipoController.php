<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Almacen;
use App\Models\Cliente;
use App\Models\FotoEquipo;
use App\Helpers\FotoHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipoController extends Controller
{
    public function index()
    {
        $equipos = Equipo::with(['cliente', 'almacen', 'fotos'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('modules.equipos.index', compact('equipos'));
    }

    public function create()
    {
        $almacenes = Almacen::all();
        $clientes = Cliente::all();
        
        return view('modules.equipos.create', compact('almacenes', 'clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'almacen_id' => 'required|exists:almacenes,id',
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string',
            'marca' => 'required|string|max:255',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        DB::beginTransaction();
        try {
            // Crear equipo
            $equipo = Equipo::create($request->except('fotos'));
            
            // Subir fotos si existen
            if ($request->hasFile('fotos')) {
                $rutasFotos = FotoHelper::subirMultiplesFotos($request->file('fotos'));
                
                foreach ($rutasFotos as $ruta) {
                    FotoEquipo::create([
                        'equipo_id' => $equipo->id,
                        'ruta' => $ruta,
                    ]);
                }
            }
            
            DB::commit();
            return redirect()->route('equipos.index')
                ->with('success', 'Equipo registrado exitosamente con fotos.');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Error al registrar el equipo: ' . $e->getMessage()]);
        }
    }

    public function show(Equipo $equipo)
    {
        $equipo->load(['cliente', 'almacen', 'fotos']);
        return view('modules.equipos.show', compact('equipo'));
    }

    public function edit(Equipo $equipo)
    {
        $almacenes = Almacen::all();
        $clientes = Cliente::all();
        $equipo->load(['fotos']);
        
        return view('modules.equipos.edit', compact('equipo', 'almacenes', 'clientes'));
    }

    public function update(Request $request, Equipo $equipo)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'almacen_id' => 'required|exists:almacenes,id',
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|string',
            'marca' => 'required|string|max:255',
            'fotos.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        DB::beginTransaction();
        try {
            $equipo->update($request->except('fotos'));
            
            // Agregar nuevas fotos si existen
            if ($request->hasFile('fotos')) {
                $rutasFotos = FotoHelper::subirMultiplesFotos($request->file('fotos'));
                
                foreach ($rutasFotos as $ruta) {
                    FotoEquipo::create([
                        'equipo_id' => $equipo->id,
                        'ruta' => $ruta,
                    ]);
                }
            }
            
            DB::commit();
            return redirect()->route('equipos.show', $equipo)
                ->with('success', 'Equipo actualizado exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Error al actualizar el equipo: ' . $e->getMessage()]);
        }
    }

    public function destroy(Equipo $equipo)
    {
        DB::beginTransaction();
        try {
            // Eliminar fotos físicas
            foreach ($equipo->fotos as $foto) {
                FotoHelper::eliminarFoto($foto->ruta);
            }
            
            $equipo->delete();
            
            DB::commit();
            return redirect()->route('equipos.index')
                ->with('success', 'Equipo eliminado exitosamente.');
                
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Error al eliminar el equipo: ' . $e->getMessage()]);
        }
    }
    
    public function eliminarFoto($fotoId)
    {
        try {
            $foto = FotoEquipo::findOrFail($fotoId);
            FotoHelper::eliminarFoto($foto->ruta);
            $foto->delete();
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
