<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Egreso;

class EgresoController extends Controller
{
    public function index() {
        return Egreso::all();
    }
    public function show($id) {
        return Egreso::findOrFail($id);
    }
    public function store(Request $request) {
        $egreso = Egreso::create($request->all());
        return response()->json($egreso, 201);
    }
    public function update(Request $request, $id) {
        $egreso = Egreso::findOrFail($id);
        $egreso->update($request->all());
        return response()->json($egreso);
    }
    public function destroy($id) {
        Egreso::destroy($id);
        return response()->json(null, 204);
    }
}
