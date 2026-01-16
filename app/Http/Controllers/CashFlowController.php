<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CashFlow;
use Carbon\Carbon;

class CashFlowController extends Controller
{
    public function index(Request $request)
    {
        $fecha_desde = $request->get('desde', now()->format('Y-m-d'));
        $fecha_hasta = $request->get('hasta', now()->format('Y-m-d'));
        $tipo = $request->get('tipo', '');
        
        $cashflow = [];
        $fondo_inicial = 0;
        $branch = (object)['name' => 'Matriz'];
        $company = (object)['name' => 'Mi Empresa'];
        
        return view('reportes.cashflow.index', compact(
            'cashflow',
            'fondo_inicial',
            'branch',
            'company',
            'fecha_desde',
            'fecha_hasta'
        ));
    }
}
