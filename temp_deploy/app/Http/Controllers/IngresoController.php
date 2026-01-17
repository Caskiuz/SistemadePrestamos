<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingreso;

class IngresoController extends Controller
{
    public function index() {
        return Ingreso::all();
    }
    public function show($id) {
        return Ingreso::findOrFail($id);
    }
    public function store(Request $request) {
        $ingreso = Ingreso::create($request->all());
        return response()->json($ingreso, 201);
    }
    public function update(Request $request, $id) {
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->update($request->all());
        return response()->json($ingreso);
    }
    public function destroy($id) {
        Ingreso::destroy($id);
        return response()->json(null, 204);
    }
}
