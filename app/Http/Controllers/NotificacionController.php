<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notificacion;

class NotificacionController extends Controller
{
    public function index()
    {
        $notificaciones = Notificacion::with(['prestamo', 'cliente'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('modules.notificaciones.index', compact('notificaciones'));
    }

    public function marcarLeida($id)
    {
        $notificacion = Notificacion::findOrFail($id);
        $notificacion->update(['enviada' => true, 'fecha_envio' => now()]);
        
        return response()->json(['success' => true]);
    }

    public function getAlertas()
    {
        $alertas = Notificacion::where('enviada', false)
            ->with(['prestamo', 'cliente'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
            
        return response()->json($alertas);
    }
}