<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Services\VerificacionExternaService;

class VerificacionController extends Controller
{
    protected $verificacionService;

    public function __construct(VerificacionExternaService $verificacionService)
    {
        $this->verificacionService = $verificacionService;
    }

    public function verificarIdentidad($clienteId)
    {
        $cliente = Cliente::findOrFail($clienteId);
        $verificacion = $this->verificacionService->verificarIdentidad($cliente);
        
        return redirect()->back()->with('success', 'Verificación de identidad procesada');
    }

    public function consultarCentrales($clienteId)
    {
        $cliente = Cliente::findOrFail($clienteId);
        $verificacion = $this->verificacionService->consultarCentralesRiesgo($cliente);
        
        return redirect()->back()->with('success', 'Consulta a centrales de riesgo procesada');
    }
}