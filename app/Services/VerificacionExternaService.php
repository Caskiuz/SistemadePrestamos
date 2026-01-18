<?php

namespace App\Services;

use App\Models\VerificacionExterna;
use App\Models\Cliente;

class VerificacionExternaService
{
    public function verificarIdentidad(Cliente $cliente)
    {
        $verificacion = VerificacionExterna::create([
            'cliente_id' => $cliente->id,
            'tipo' => 'identidad',
            'servicio' => 'reniec',
            'datos_enviados' => [
                'numero_documento' => $cliente->numero_documento,
                'tipo_documento' => $cliente->tipo_documento
            ],
            'estado' => 'pendiente',
            'fecha_consulta' => now()
        ]);

        try {
            $response = $this->consultarReniec($cliente->numero_documento);
            
            $verificacion->update([
                'respuesta' => $response,
                'estado' => 'exitoso',
                'resultado' => $response['valido'] ? 'aprobado' : 'rechazado'
            ]);

            return $verificacion;
        } catch (\Exception $e) {
            $verificacion->update([
                'estado' => 'fallido',
                'observaciones' => $e->getMessage()
            ]);
            
            return $verificacion;
        }
    }

    public function consultarCentralesRiesgo(Cliente $cliente)
    {
        $verificacion = VerificacionExterna::create([
            'cliente_id' => $cliente->id,
            'tipo' => 'centrales_riesgo',
            'servicio' => 'sbs',
            'datos_enviados' => [
                'numero_documento' => $cliente->numero_documento,
                'nombres' => $cliente->nombre
            ],
            'estado' => 'pendiente',
            'fecha_consulta' => now()
        ]);

        try {
            $response = $this->consultarSBS($cliente->numero_documento);
            
            $verificacion->update([
                'respuesta' => $response,
                'estado' => 'exitoso',
                'resultado' => $this->evaluarRiesgo($response)
            ]);

            return $verificacion;
        } catch (\Exception $e) {
            $verificacion->update([
                'estado' => 'fallido',
                'observaciones' => $e->getMessage()
            ]);
            
            return $verificacion;
        }
    }

    private function consultarReniec($documento)
    {
        return [
            'valido' => true,
            'nombres' => 'JUAN CARLOS',
            'apellidos' => 'PEREZ GARCIA',
            'estado' => 'HABILITADO'
        ];
    }

    private function consultarSBS($documento)
    {
        return [
            'calificacion' => 'NORMAL',
            'deudas_sistema_financiero' => 0,
            'protestos' => 0,
            'score' => 750
        ];
    }

    private function evaluarRiesgo($response)
    {
        if ($response['calificacion'] === 'NORMAL' && $response['score'] > 600) {
            return 'aprobado';
        } elseif ($response['score'] > 400) {
            return 'observado';
        } else {
            return 'rechazado';
        }
    }
}