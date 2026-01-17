@extends('layouts.main')
@section('contenido')
<div class="section-header">
    <h1>Prendas / Productos</h1>
    <a href="{{ route('inventario.create') }}" class="btn btn-primary float-right">Registrar nuevo producto/prenda</a>
</div>
<div class="section-body">
    <div class="card">
        <div class="card-header">
            <h4>Inventario de Prendas / Productos</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Almacén</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                    <tr>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->tipo }}</td>
                        <td>{{ $producto->almacen->nombre ?? '-' }}</td>
                        <td>{{ $producto->estado }}</td>
                        <td>
                            <a href="{{ route('inventario.show', $producto->id) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('inventario.edit', $producto->id) }}" class="btn btn-warning btn-sm">Editar</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
