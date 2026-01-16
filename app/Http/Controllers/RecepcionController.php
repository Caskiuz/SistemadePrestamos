<?php

namespace App\Http\Controllers;

use App\Models\Recepcion;
use App\Models\Cliente;
use App\Models\Equipo;
use App\Models\FotoEquipo;
use App\Models\importanteModel;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\Ingreso;



class RecepcionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {    

        $query = Recepcion::with(['cliente', 'usuario', 'cotizacion']) // Agregar cotizacion
            ->orderBy('created_at', 'desc');
        if ($request->filled('buscar')) {
            $busqueda = $request->buscar;
            $query->where(function ($q) use ($busqueda) {
                $q->where('numero_recepcion', 'like', "%$busqueda%")
                    ->orWhereHas('cliente', function ($qc) use ($busqueda) {
                        $qc->where('nombre', 'like', "%$busqueda%");
                    })
                    ->orWhereHas('usuario', function ($qu) use ($busqueda) {
                        $qu->where('nombre', 'like', "%$busqueda%");
                    });
            });
        }

        $recepciones = $query->paginate(10)->appends($request->only('buscar', 'cliente', 'usuario'));

        return view('modules.recepciones.index', [
            'recepciones' => $recepciones
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $importante = DB::table('importante')->value('importante');
        $ultimaRecepcion = Recepcion::latest()->first();
        if ($ultimaRecepcion) {
            $ultimoNumero = (int) Str::after($ultimaRecepcion->numero_recepcion, 'REC-00');
            $numeroRecepcion = 'REC-00' . str_pad($ultimoNumero + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $numeroRecepcion = 'REC-005512';
        }

        $usuario = Auth::user();
        $clientes = Cliente::all();

        return view('modules.recepciones.create', compact('clientes', 'numeroRecepcion', 'importante'));
    }

    public function store(Request $request)
{
    // Validación de datos
    $validated = $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
        'numero_recepcion' => 'required|unique:recepciones,numero_recepcion',
        'fecha_ingreso' => 'required|date',
        'hora_ingreso' => 'required',
        'tipo_recepcion' => 'required',
        'observaciones' => 'nullable|string',

        'equipos' => 'required|array|min:1',
        'equipos.*.tipo' => 'required|in:MOTOR_ELECTRICO,MAQUINA_SOLDADORA,GENERADOR_DINAMO,OTROS',
        'equipos.*.marca' => 'required|string|max:255',
        'equipos.*.nombre' => 'required|string|max:255',
        'equipos.*.monto' => 'required|numeric|min:0',
        'equipos.*.color' => 'required|array|min:1|max:2',
        'equipos.*.color.*' => 'required|in:Inox,Negro,Blanco,Gris,Rojo,Azul,Verde,Amarillo,Naranja,Morado,Rosado,Marrón,Cian',

        'equipos.*.fotos' => 'nullable|array|max:12',
        'equipos.*.fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:12288',
        'equipos.*.camera_photos' => 'nullable|array',
    ]);

    DB::beginTransaction();
    try {
        // Crear la recepción
        $recepcion = Recepcion::create([
            'numero_recepcion' => $request->numero_recepcion,
            'cliente_id' => $request->cliente_id,
            'user_id' => Auth::id(),
            'fecha_ingreso' => $request->fecha_ingreso,
            'hora_ingreso' => $request->hora_ingreso,
            'observaciones' => $request->observaciones,
            'tipo_recepcion' => $request->tipo_recepcion,
            'estado' => 'RECIBIDO'
        ]);

        $montoTotal = 0;

        // Guardar los equipos
        foreach ($request->equipos as $index => $equipoData) {
            $hasFilePhotos = isset($equipoData['fotos']) && count($equipoData['fotos']) > 0;
            $hasCameraPhotos = isset($equipoData['camera_photos']) && count($equipoData['camera_photos']) > 0;

            

            $equipo = new Equipo([
                'recepcion_id' => $recepcion->id,
                'cliente_id' => $request->cliente_id,
                'nombre' => $equipoData['nombre'],
                'tipo' => $equipoData['tipo'],
                'modelo' => $equipoData['modelo'] ?? null,
                'marca' => $equipoData['marca'],
                'numero_serie' => $equipoData['serie'] ?? null,
                'color' => isset($equipoData['color']) ? implode(',', (array)$equipoData['color']) : null,
                'voltaje' => $equipoData['voltaje'] ?? null,
                'hp' => $equipoData['hp'] ?? null,
                'rpm' => $equipoData['rpm'] ?? null,
                'hz' => $equipoData['hz'] ?? null,
                'amperaje' => $equipoData['amperaje'] ?? null,
                'cable_positivo' => $equipoData['cable_positivo'] ?? null,
                'cable_negativo' => $equipoData['cable_negativo'] ?? null,
                'kva_kw' => $equipoData['kva_kw'] ?? null,
                'potencia' => $equipoData['potencia'] ?? null,
                'potencia_unidad' => $equipoData['potencia_unidad'] ?? null,
                'monto' => $equipoData['monto'] ?? 0,
            ]);
            $equipo->save();

            // Sumar monto total
            $montoTotal += $equipo->monto;

            // Guardar fotos de archivos
            if (isset($equipoData['fotos'])) {
                foreach ($equipoData['fotos'] as $foto) {
                    $path = $this->storeImage($foto, $equipo->id);
                    FotoEquipo::create([
                        'equipo_id' => $equipo->id,
                        'ruta' => $path,
                        'descripcion' => 'Foto subida'
                    ]);
                }
            }

            // Guardar fotos de cámara
            if (isset($equipoData['camera_photos'])) {
                foreach ($equipoData['camera_photos'] as $base64Photo) {
                    $path = $this->storeBase64Image($base64Photo, $equipo->id);
                    FotoEquipo::create([
                        'equipo_id' => $equipo->id,
                        'ruta' => $path,
                        'descripcion' => 'Foto tomada con cámara'
                    ]);
                }
            }
        }

       $importante = importanteModel::first() ?? new importanteModel();
        $importante->importante = $request->importante;
        $importante->save();
        
        // Crear el registro en la tabla INGRESOS
        $cliente = Cliente::find($request->cliente_id);

        // Determinar estado de pago según monto
            $estadoPago = $montoTotal > 0 ? 'Completo' : 'Pendiente';
        Ingreso::create([
            'tipo_ingreso' => 'Recepción',
            'glosa' => 'Ingreso por recepción ' . $recepcion->numero_recepcion,
            'razon_social' => $cliente ? $cliente->nombre : 'Desconocido',
            'nro_recibo' => $recepcion->numero_recepcion,
            'metodo_pago' => $request->metodo_pago ?? 'Pendiente', // <-- aquí
            'subtotal' => $montoTotal,
            'descuento' => 0,
            'total' => $montoTotal,
            'estado_pago' => $estadoPago
        ]);
            $request->validate([
                'cliente_id' => 'required|exists:clientes,id',
                'metodo_pago' => 'required|string',
            ]);
        DB::commit();

        return response()->json([
            'success' => true,
            'recepcion_id' => $recepcion->id
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}

    /**
     * Display the specified resource.
     */
    public function show(Recepcion $recepcion)
    {
        $recepcion->load(['cliente', 'usuario', 'equipos']);
        // Buscar cotización asociada
        $cotizacion = \App\Models\Cotizacion::where('recepcion_id', $recepcion->id)->first();

        return view('modules.recepciones.show', [
            'recepcion' => $recepcion,
            'cotizacion' => $cotizacion
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recepcion $recepcion)
    {
        $recepcion->load(['cliente', 'usuario', 'equipos.fotos']);

        return view('modules.recepciones.edit_estado', compact('recepcion'));
    }

    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, Recepcion $recepcion)
{
    // Validación
    $validated = $request->validate([
        'equipos' => 'required|array|min:1',
        'equipos.*.nombre' => 'required|string|max:255',
        'equipos.*.tipo' => 'required|in:MOTOR_ELECTRICO,MAQUINA_SOLDADORA,GENERADOR_DINAMO,OTROS',
        'equipos.*.marca' => 'required|string|max:255',
        'equipos.*.monto' => 'required|numeric|min:0',
        'equipos.*.fotos' => 'nullable|array|max:12',
        'equipos.*.fotos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:12288',
        'equipos.*.camera_photos' => 'nullable|array',
        'deleted_photos' => 'nullable|string',
        'observaciones' => 'nullable|string|max:1000',
    ]);

    DB::beginTransaction();
    try {
        // Eliminar fotos marcadas para eliminación
        if ($request->deleted_photos) {
            $deletedPhotos = json_decode($request->deleted_photos);
            if (is_array($deletedPhotos)) {
                foreach ($deletedPhotos as $photoId) {
                    $foto = FotoEquipo::find($photoId);
                    if ($foto) {
                        Storage::disk('public')->delete($foto->ruta);
                        $foto->delete();
                    }
                }
            }
        }

        // Actualizar observaciones de la recepción
        $recepcion->update([
            'observaciones' => $request->observaciones ?? $recepcion->observaciones,
        ]);

        // Actualizar o crear equipos
        foreach ($request->equipos as $index => $equipoData) {
            if (isset($equipoData['id'])) {
                // Actualizar equipo existente
                $equipo = Equipo::find($equipoData['id']);
                if ($equipo) {
                    $equipo->update([
                        'nombre' => $equipoData['nombre'],
                        'modelo' => $equipoData['modelo'] ?? null,
                        'marca' => $equipoData['marca'],
                        'numero_serie' => $equipoData['serie'] ?? null,
                        'color' => isset($equipoData['color']) ? implode(',', (array)$equipoData['color']) : null,
                        'voltaje' => $equipoData['voltaje'] ?? null,
                        'hp' => $equipoData['hp'] ?? null,
                        'rpm' => $equipoData['rpm'] ?? null,
                        'hz' => $equipoData['hz'] ?? null,
                        'amperaje' => $equipoData['amperaje'] ?? null,
                        'cable_positivo' => $equipoData['cable_positivo'] ?? null,
                        'cable_negativo' => $equipoData['cable_negativo'] ?? null,
                        'kva_kw' => $equipoData['kva_kw'] ?? null,
                        'potencia' => $equipoData['potencia'] ?? null,
                        'potencia_unidad' => $equipoData['potencia_unidad'] ?? null,
                        'monto' => $equipoData['monto'],
                    ]);
                }
            } else {
                // Crear nuevo equipo
                $equipo = new Equipo([
                    'recepcion_id' => $recepcion->id,
                    'cliente_id' => $recepcion->cliente_id,
                    'nombre' => $equipoData['nombre'],
                    'modelo' => $equipoData['modelo'] ?? null,
                    'marca' => $equipoData['marca'],
                    'numero_serie' => $equipoData['serie'] ?? null,
                    'color' => isset($equipoData['color']) ? implode(',', (array)$equipoData['color']) : null,
                    'voltaje' => $equipoData['voltaje'] ?? null,
                    'hp' => $equipoData['hp'] ?? null,
                    'rpm' => $equipoData['rpm'] ?? null,
                    'hz' => $equipoData['hz'] ?? null,
                    'amperaje' => $equipoData['amperaje'] ?? null,
                    'cable_positivo' => $equipoData['cable_positivo'] ?? null,
                    'cable_negativo' => $equipoData['cable_negativo'] ?? null,
                    'kva_kw' => $equipoData['kva_kw'] ?? null,
                    'potencia' => $equipoData['potencia'] ?? null,
                    'potencia_unidad' => $equipoData['potencia_unidad'] ?? null,
                    'monto' => $equipoData['monto'],
                ]);
                $equipo->save();
            }

            // Guardar nuevas fotos
            if (isset($equipoData['fotos'])) {
                foreach ($equipoData['fotos'] as $foto) {
                    $path = $this->storeImage($foto, $equipo->id);
                    FotoEquipo::create([
                        'equipo_id' => $equipo->id,
                        'ruta' => $path,
                        'descripcion' => 'Nueva foto agregada'
                    ]);
                }
            }

            // Guardar fotos de cámara
            if (isset($equipoData['camera_photos'])) {
                foreach ($equipoData['camera_photos'] as $base64Photo) {
                    $path = $this->storeBase64Image($base64Photo, $equipo->id);
                    FotoEquipo::create([
                        'equipo_id' => $equipo->id,
                        'ruta' => $path,
                        'descripcion' => 'Foto tomada con cámara'
                    ]);
                }
            }
        }

        // 🔹 Recalcular monto total de la recepción
        $montoTotalActualizado = $recepcion->equipos()->sum('monto');

        // 🔹 Actualizar registro de Ingreso
        $ingreso = Ingreso::where('nro_recibo', $recepcion->numero_recepcion)->first();
        if ($ingreso) {
            $estadoPago = $montoTotalActualizado > 0 ? 'Completo' : 'Pendiente';
            $ingreso->update([
                'subtotal' => $montoTotalActualizado,
                'total' => $montoTotalActualizado,
                'estado_pago' => $estadoPago,
                'metodo_pago' => $request->metodo_pago ?? $ingreso->metodo_pago, // <-- agregado
            ]);
        }

        DB::commit();

        return redirect()->route('recepciones.index', $recepcion)
            ->with('success', 'Equipos y monto de ingreso actualizados correctamente');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('recepciones.index', $recepcion)
            ->with('error', 'Error al actualizar: ' . $e->getMessage());
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recepcion $recepcion)
    {
        try {
            // Eliminar cotización asociada (si existe)
            if ($recepcion->cotizacion) {
                // Si la cotización tiene detalles, elimínalos aquí
                // Por ejemplo: $recepcion->cotizacion->detalles()->delete();
                $recepcion->cotizacion->delete();
            }

            // Eliminar equipos y sus fotos
            foreach ($recepcion->equipos as $equipo) {
                // Eliminar fotos del equipo
                foreach ($equipo->fotos as $foto) {
                    // Eliminar archivo físico
                    \Storage::disk('public')->delete($foto->ruta);
                    $foto->delete();
                }
                $equipo->delete();
            }

            // Finalmente, eliminar la recepción
            $recepcion->delete();

            return redirect()->route('recepciones.index')
                ->with('swal', [
                    'icon' => 'success',
                    'title' => '¡Eliminado!',
                    'text' => 'Recepción eliminada correctamente'
                ]);
        } catch (\Exception $e) {
            return redirect()->route('recepciones.index')
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Error',
                    'text' => 'Error al eliminar la recepción: ' . $e->getMessage()
                ]);
        }
    }

private function storeImage($foto, $equipoId)
{
    // Ruta real hacia public_html
    $folder = base_path('../public_html/equipos_fotos');

    if (!file_exists($folder)) {
        mkdir($folder, 0755, true); // Crear la carpeta si no existe
    }

    // Crear nombre único
    $nombre = 'equipo_' . $equipoId . '_' . time() . '_' . Str::random(8) . '.' . $foto->getClientOriginalExtension();

    // Ruta final
    $ruta = $folder . '/' . $nombre;

    // Mover archivo al directorio público
    $foto->move($folder, $nombre);

    \Log::info('Archivo subido a servidor', [
        'ruta_fisica' => $ruta,
        'ruta_web' => url('equipos_fotos/' . $nombre)
    ]);

    // Retornar ruta relativa web
    return 'equipos_fotos/' . $nombre;
}


private function storeBase64Image($base64String, $equipoId)
{
    if (preg_match('/^data:image\/(\w+);base64,/', $base64String, $type)) {
        $base64String = substr($base64String, strpos($base64String, ',') + 1);
        $type = strtolower($type[1]); // jpg, png, etc.

        $imageData = base64_decode($base64String);
        if ($imageData === false) {
            throw new \Exception('No se pudo decodificar la imagen base64');
        }

        $filename = 'equipo_' . $equipoId . '_' . time() . '_' . Str::random(8) . '.' . $type;

        // Carpeta en public_html
        $directory = base_path('../public_html/equipos_fotos');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $path = $directory . '/' . $filename;
        file_put_contents($path, $imageData);

        \Log::info('Archivo base64 guardado en public_html', ['ruta' => $path]);

        return 'equipos_fotos/' . $filename; // ruta relativa para base de datos
    } else {
        throw new \Exception('Formato base64 inválido');
    }
}



    public function generatePdf(Recepcion $recepcion)
    {
        $importante = importanteModel::first(); // o find($id) según tu caso

        $equipos = $recepcion->equipos;

        $pdf = Pdf::loadView('modules.recepciones.pdf', compact('recepcion', 'importante'))  //Cargar la vista y pasar los datos
            ->setPaper('letter', 'portrait'); // Horizontal
        return $pdf->stream('recepcion_' . $recepcion->numero_recepcion . '.pdf'); // Se abre en navegador
    }
}
