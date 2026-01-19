<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auditoria;

class AuditoriaController extends Controller
{
    public function index()
    {
        $auditorias = Auditoria::with('usuario')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('modules.sistema.auditoria', compact('auditorias'));
    }
}