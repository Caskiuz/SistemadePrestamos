@extends('layouts.main')
@section('contenido')
<div class="section-header">
    <h1>Registrar Sucursal / Almacén</h1>
</div>
<div class="section-body">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('almacenes.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre de la sucursal/almacén</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="activo">Estado</label>
                    <select name="activo" id="activo" class="form-control">
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Registrar</button>
                <a href="{{ route('almacenes.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
