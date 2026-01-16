@extends('layouts.main')
@section('contenido')
<div class="section-header">
    <h1>Registrar nuevo producto/prenda</h1>
</div>
<div class="section-body">
    <div class="card">
        <div class="card-header">
            <h4>Formulario de registro</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('inventario.store') }}">
                @csrf
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <input type="text" name="tipo" id="tipo" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="almacen_id">Almacén</label>
                    <select name="almacen_id" id="almacen_id" class="form-control">
                        <!-- Opciones de almacén -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="estado">Estado</label>
                    <select name="estado" id="estado" class="form-control">
                        <option value="disponible">Disponible</option>
                        <option value="apartado">Apartado</option>
                        <option value="empeñado">Empeñado</option>
                        <option value="vendido">Vendido</option>
                        <option value="liquidado">Liquidado</option>
                        <option value="cancelado">Cancelado</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Registrar</button>
            </form>
        </div>
    </div>
</div>
@endsection
