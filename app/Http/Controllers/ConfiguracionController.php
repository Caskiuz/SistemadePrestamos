<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\Empleado;
use App\Models\Interes;

class ConfiguracionController extends Controller
{
    public function index() {
        return view('modules.configuracion.index');
    }

    public function empresa() {
        $almacenes = Almacen::all();
        $empleados = Empleado::all();
        $intereses = Interes::all();
        return view('modules.configuracion.empresa', compact('almacenes', 'empleados', 'intereses'));
    }

    public function sucursal() {
        $almacenes = Almacen::all();
        return view('modules.configuracion.sucursal', compact('almacenes'));
    }

    public function empleados() {
        $empleados = Empleado::all();
        return view('modules.configuracion.empleados', compact('empleados'));
    }

    public function intereses() {
        $intereses = Interes::all();
        return view('modules.configuracion.intereses', compact('intereses'));
    }

    public function recibos() {
        return view('modules.configuracion.recibos');
    }

    public function region() {
        return view('modules.configuracion.region');
    }

    public function roles() {
        return view('modules.configuracion.roles');
    }
}
