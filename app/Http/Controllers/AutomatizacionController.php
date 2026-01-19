<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NotificacionService;
use App\Models\Prestamo;
use App\Models\Notificacion;
use Illuminate\Support\Facades\Artisan;

class AutomatizacionController extends Controller
{
    private $notificacionService;
    
    public function __construct(NotificacionService $notificacionService)
    {
        $this->notificacionService = $notificacionService;
    }
    
    public function index()
    {
        $estadisticas = [
            'notificaciones_enviadas_hoy' => Notificacion::whereDate('created_at', today())->count(),
            'notificaciones_pendientes' => Notificacion::where('enviada', false)->count(),
            'prestamos_por_vencer' => Prestamo::where('estado', 'activo')
                ->whereBetween('fecha_vencimiento', [now(), now()->addDays(3)])
                ->count(),
            'procesos_activos' => $this->getProcesosActivos()
        ];
        
        return view('modules.automatizacion.index', compact('estadisticas'));
    }
    
    public function enviarNotificacionManual(Request $request)
    {
        $request->validate([
            'prestamo_id' => 'required|exists:prestamos,id',
            'tipo' => 'required|in:vencimiento_proximo,vencido,pago_recibido,renovacion',
            'canal' => 'required|in:email,sms,whatsapp,todos'
        ]);
        
        $prestamo = Prestamo::with('cliente')->findOrFail($request->prestamo_id);
        
        $resultado = $this->notificacionService->enviarNotificacion(
            $request->tipo,
            $prestamo,
            $request->canal
        );
        
        if ($resultado) {
            return response()->json([
                'success' => true,
                'message' => 'Notificación enviada correctamente'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Error al enviar la notificación'
        ], 500);
    }
    
    public function ejecutarProcesoBatch(Request $request)
    {
        $proceso = $request->get('proceso');
        
        try {
            switch ($proceso) {
                case 'notificaciones':
                    Artisan::call('notificaciones:generar');
                    break;
                case 'batch':
                    Artisan::call('batch:procesar');
                    break;
                case 'vencidos':
                    Artisan::call('prestamos:actualizar-vencidos');
                    break;
                default:
                    throw new \Exception('Proceso no válido');
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Proceso ejecutado correctamente',
                'output' => Artisan::output()
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al ejecutar el proceso: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function getEstadisticasAjax()
    {
        return response()->json([
            'notificaciones_hoy' => Notificacion::whereDate('created_at', today())->count(),
            'notificaciones_pendientes' => Notificacion::where('enviada', false)->count(),
            'prestamos_vencer' => Prestamo::where('estado', 'activo')
                ->whereBetween('fecha_vencimiento', [now(), now()->addDays(3)])
                ->count(),
            'ultimo_proceso' => $this->getUltimoProceso()
        ]);
    }
    
    private function getProcesosActivos()
    {
        return [
            'notificaciones' => true,
            'batch_diario' => true,
            'actualizacion_estados' => true,
            'backup_automatico' => true
        ];
    }
    
    private function getUltimoProceso()
    {
        $logFile = storage_path('logs/laravel.log');
        
        if (!file_exists($logFile)) {
            return 'Sin información';
        }
        
        $lines = file($logFile);
        $lastLines = array_slice($lines, -10);
        
        foreach (array_reverse($lastLines) as $line) {
            if (strpos($line, 'notificaciones:generar') !== false || 
                strpos($line, 'batch:procesar') !== false) {
                return date('d/m/Y H:i', strtotime(substr($line, 1, 19)));
            }
        }
        
        return 'Sin información';
    }
}