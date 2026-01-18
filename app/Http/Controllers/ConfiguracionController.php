<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracion;
use App\Models\Almacen;
use App\Models\User;

class ConfiguracionController extends Controller
{
    private function verificarGerente()
    {
        if (!auth()->check() || auth()->user()->rol !== 'Gerente') {
            abort(403, 'Acceso denegado. Solo gerentes pueden acceder a la configuración.');
        }
    }

    public function index()
    {
        $this->verificarGerente();
        return view('modules.configuracion.index');
    }

    public function empresa()
    {
        $this->verificarGerente();
        $configuraciones = Configuracion::where('categoria', 'empresa')->get()->keyBy('clave');
        return view('modules.configuracion.empresa', compact('configuraciones'));
    }

    public function prestamos()
    {
        $this->verificarGerente();
        $configuraciones = Configuracion::where('categoria', 'prestamos')->get()->keyBy('clave');
        return view('modules.configuracion.prestamos', compact('configuraciones'));
    }

    public function tarifas()
    {
        $this->verificarGerente();
        $configuraciones = Configuracion::where('categoria', 'tarifas')->get()->keyBy('clave');
        return view('modules.configuracion.tarifas', compact('configuraciones'));
    }

    public function notificaciones()
    {
        $this->verificarGerente();
        $configuraciones = Configuracion::where('categoria', 'notificaciones')->get()->keyBy('clave');
        return view('modules.configuracion.notificaciones', compact('configuraciones'));
    }

    public function sistema()
    {
        $this->verificarGerente();
        $configuraciones = Configuracion::where('categoria', 'sistema')->get()->keyBy('clave');
        return view('modules.configuracion.sistema', compact('configuraciones'));
    }

    public function seguridad()
    {
        $this->verificarGerente();
        $configuraciones = Configuracion::where('categoria', 'seguridad')->get()->keyBy('clave');
        return view('modules.configuracion.seguridad', compact('configuraciones'));
    }

    public function reportes()
    {
        $this->verificarGerente();
        $configuraciones = Configuracion::where('categoria', 'reportes')->get()->keyBy('clave');
        return view('modules.configuracion.reportes', compact('configuraciones'));
    }

    public function actualizar(Request $request)
    {
        $this->verificarGerente();
        foreach ($request->except(['_token', '_method']) as $clave => $valor) {
            Configuracion::where('clave', $clave)->update(['valor' => $valor]);
        }

        return redirect()->back()->with('success', 'Configuración actualizada exitosamente');
    }
}