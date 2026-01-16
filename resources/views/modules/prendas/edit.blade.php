@extends('layouts.main')
@section('contenido')
<div class="section-header">
    <h1>Editar producto/prenda</h1>
</div>
<div class="section-body">
    <div class="card">
        <div class="card-header">
            <h4>Formulario de edición</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('inventario.update', $producto->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $producto->nombre }}" required>
                </div>
                <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <input type="text" name="tipo" id="tipo" class="form-control" value="{{ $producto->tipo }}" required>
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
                        <option value="disponible" {{ $producto->estado == 'disponible' ? 'selected' : '' }}>Disponible</option>
                        <option value="apartado" {{ $producto->estado == 'apartado' ? 'selected' : '' }}>Apartado</option>
                        <option value="empeñado" {{ $producto->estado == 'empeñado' ? 'selected' : '' }}>Empeñado</option>
                        <option value="vendido" {{ $producto->estado == 'vendido' ? 'selected' : '' }}>Vendido</option>
                        <option value="liquidado" {{ $producto->estado == 'liquidado' ? 'selected' : '' }}>Liquidado</option>
                        <option value="cancelado" {{ $producto->estado == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Actualizar</button>
            </form>
        </div>
    </div>
</div>
@endsection
