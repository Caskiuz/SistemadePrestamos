@extends('layouts.main')
@section('contenido')
<div class="section-header bg-primary text-white rounded shadow-sm py-3 px-4 mb-4 align-items-center d-flex justify-content-between">
    <h1 class="mb-0" style="font-weight: 700; letter-spacing: 1px;"><i class="fas fa-warehouse mr-2"></i>Sucursales / Almacenes</h1>
    <a href="{{ route('almacenes.create') }}" class="btn btn-success btn-lg shadow-sm"><i class="fas fa-plus"></i> Nueva Sucursal/Almacén</a>
</div>
<div class="section-body">
    <div class="card shadow-sm">
        <div class="card-header bg-light border-bottom-0">
            <h4 class="mb-0" style="font-size:21px; color:#151414"><i class="fas fa-list-alt mr-2"></i>Listado de Sucursales / Almacenes</h4>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered bg-white rounded shadow-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Estado</th>
                        <th style="width:140px">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($almacenes as $almacen)
                    <tr>
                        <td><span class="font-weight-bold">{{ $almacen->nombre }}</span></td>
                        <td>{{ $almacen->direccion }}</td>
                        <td>
                            <span class="badge {{ $almacen->activo ? 'badge-success' : 'badge-secondary' }}">{{ $almacen->activo ? 'Activo' : 'Inactivo' }}</span>
                        </td>
                        <td>
                            <a href="{{ route('almacenes.edit', $almacen->id) }}" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('almacenes.destroy', $almacen->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar sucursal/almacén?')" title="Eliminar"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No hay sucursales/almacenes registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
