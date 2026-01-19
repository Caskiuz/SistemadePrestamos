<?php

namespace App\Services;

use App\Models\Notificacion;
use App\Models\Configuracion;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificacionService
{
    public function enviarNotificacion($tipo, $prestamo, $canal = 'todos')
    {
        $configuracion = $this->getConfiguracion();
        
        if (!$configuracion['notif_automaticas']) {
            return false;
        }

        $notificacion = $this->crearNotificacion($tipo, $prestamo);
        
        if ($canal === 'todos' || $canal === 'email') {
            $this->enviarEmail($notificacion);
        }
        
        if ($canal === 'todos' || $canal === 'sms') {
            $this->enviarSMS($notificacion);
        }
        
        if ($canal === 'todos' || $canal === 'whatsapp') {
            $this->enviarWhatsApp($notificacion);
        }
        
        return true;
    }
    
    private function crearNotificacion($tipo, $prestamo)
    {
        $mensajes = $this->getMensajes($tipo, $prestamo);
        
        return Notificacion::create([
            'tipo' => $tipo,
            'titulo' => $mensajes['titulo'],
            'mensaje' => $mensajes['mensaje'],
            'prestamo_id' => $prestamo->id,
            'cliente_id' => $prestamo->cliente_id,
            'canal' => 'multiple',
            'enviada' => false
        ]);
    }
    
    private function enviarEmail($notificacion)
    {
        try {
            $cliente = $notificacion->cliente;
            
            if (!$cliente->email) {
                return false;
            }
            
            Mail::send('emails.notificacion', [
                'cliente' => $cliente,
                'notificacion' => $notificacion,
                'prestamo' => $notificacion->prestamo
            ], function ($message) use ($cliente, $notificacion) {
                $message->to($cliente->email, $cliente->nombre)
                       ->subject($notificacion->titulo);
            });
            
            $this->marcarEnviada($notificacion, 'email');
            return true;
            
        } catch (\Exception $e) {
            Log::error('Error enviando email: ' . $e->getMessage());
            return false;
        }
    }
    
    private function enviarSMS($notificacion)
    {
        try {
            $cliente = $notificacion->cliente;
            
            if (!$cliente->telefono) {
                return false;
            }
            
            $configuracion = $this->getConfiguracion();
            
            // Usando Twilio como ejemplo
            if ($configuracion['sms_provider'] === 'twilio') {
                return $this->enviarTwilio($cliente->telefono, $notificacion->mensaje);
            }
            
            // Usando API local/nacional
            if ($configuracion['sms_provider'] === 'local') {
                return $this->enviarSMSLocal($cliente->telefono, $notificacion->mensaje);
            }
            
            return false;
            
        } catch (\Exception $e) {
            Log::error('Error enviando SMS: ' . $e->getMessage());
            return false;
        }
    }
    
    private function enviarWhatsApp($notificacion)
    {
        try {
            $cliente = $notificacion->cliente;
            
            if (!$cliente->telefono) {
                return false;
            }
            
            $configuracion = $this->getConfiguracion();
            
            // Usando WhatsApp Business API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $configuracion['whatsapp_token'],
                'Content-Type' => 'application/json'
            ])->post($configuracion['whatsapp_url'], [
                'messaging_product' => 'whatsapp',
                'to' => $cliente->telefono,
                'type' => 'text',
                'text' => [
                    'body' => $notificacion->mensaje
                ]
            ]);
            
            if ($response->successful()) {
                $this->marcarEnviada($notificacion, 'whatsapp');
                return true;
            }
            
            return false;
            
        } catch (\Exception $e) {
            Log::error('Error enviando WhatsApp: ' . $e->getMessage());
            return false;
        }
    }
    
    private function enviarTwilio($telefono, $mensaje)
    {
        $configuracion = $this->getConfiguracion();
        
        $response = Http::withBasicAuth(
            $configuracion['twilio_sid'],
            $configuracion['twilio_token']
        )->asForm()->post("https://api.twilio.com/2010-04-01/Accounts/{$configuracion['twilio_sid']}/Messages.json", [
            'From' => $configuracion['twilio_from'],
            'To' => $telefono,
            'Body' => $mensaje
        ]);
        
        return $response->successful();
    }
    
    private function enviarSMSLocal($telefono, $mensaje)
    {
        $configuracion = $this->getConfiguracion();
        
        // Ejemplo para API SMS local (Venezuela, Colombia, etc.)
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $configuracion['sms_api_key']
        ])->post($configuracion['sms_api_url'], [
            'to' => $telefono,
            'message' => $mensaje,
            'from' => $configuracion['sms_from']
        ]);
        
        return $response->successful();
    }
    
    private function getMensajes($tipo, $prestamo)
    {
        $cliente = $prestamo->cliente;
        $empresa = $this->getConfiguracion()['empresa_nombre'] ?? 'Préstamos Santa Ana';
        
        switch ($tipo) {
            case 'vencimiento_proximo':
                return [
                    'titulo' => 'Préstamo próximo a vencer',
                    'mensaje' => "Hola {$cliente->nombre}, su préstamo #{$prestamo->folio} vence el {$prestamo->fecha_vencimiento->format('d/m/Y')}. Recuerde realizar su pago a tiempo. - {$empresa}"
                ];
                
            case 'vencido':
                return [
                    'titulo' => 'Préstamo vencido',
                    'mensaje' => "Hola {$cliente->nombre}, su préstamo #{$prestamo->folio} venció el {$prestamo->fecha_vencimiento->format('d/m/Y')}. Por favor acérquese a regularizar su situación. - {$empresa}"
                ];
                
            case 'pago_recibido':
                return [
                    'titulo' => 'Pago recibido',
                    'mensaje' => "Hola {$cliente->nombre}, hemos recibido su pago del préstamo #{$prestamo->folio}. Gracias por su puntualidad. - {$empresa}"
                ];
                
            case 'renovacion':
                return [
                    'titulo' => 'Préstamo renovado',
                    'mensaje' => "Hola {$cliente->nombre}, su préstamo #{$prestamo->folio} ha sido renovado exitosamente. Nueva fecha de vencimiento: {$prestamo->fecha_vencimiento->format('d/m/Y')}. - {$empresa}"
                ];
                
            default:
                return [
                    'titulo' => 'Notificación',
                    'mensaje' => "Hola {$cliente->nombre}, tiene una notificación sobre su préstamo #{$prestamo->folio}. - {$empresa}"
                ];
        }
    }
    
    private function getConfiguracion()
    {
        $configs = Configuracion::pluck('valor', 'clave')->toArray();
        
        return array_merge([
            'notif_automaticas' => true,
            'notif_dias_vencimiento' => 3,
            'notif_hora_envio' => '08:00',
            'sms_provider' => 'local',
            'empresa_nombre' => 'Préstamos Santa Ana'
        ], $configs);
    }
    
    private function marcarEnviada($notificacion, $canal)
    {
        $notificacion->update([
            'enviada' => true,
            'fecha_envio' => now(),
            'canal' => $canal
        ]);
    }
}