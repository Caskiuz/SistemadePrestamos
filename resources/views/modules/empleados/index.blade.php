@extends('layouts.main')
@section('contenido')
<div class="section-header bg-primary text-white rounded shadow-sm py-3 px-4 mb-4 align-items-center d-flex justify-content-between">
    <h1 class="mb-0" style="font-weight: 700; letter-spacing: 1px;"><i class="fas fa-user-tie mr-2"></i>Empleados</h1>
    <a href="{{ route('empleados.create') }}" class="btn btn-success btn-lg shadow-sm"><i class="fas fa-user-plus"></i> Nuevo Empleado</a>
</div>
<div class="section-body">
    <div class="card shadow-sm">
        <div class="card-header bg-light border-bottom-0">
            <h4 class="mb-0" style="font-size:21px; color:#151414"><i class="fas fa-address-card mr-2"></i>Listado de Empleados</h4>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered bg-white rounded shadow-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Rol</th>
                        <th>Horario</th>
                        <th style="width:120px">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($empleados as $empleado)
                    <tr>
                        <td><span class="font-weight-bold">{{ $empleado->nombre }}</span></td>
                        <td><span class="badge badge-info">{{ $empleado->rol }}</span></td>
                        <td>{{ $empleado->horario }}</td>
                        <td>
                            <a href="{{ route('empleados.show', $empleado->id) }}" class="btn btn-info btn-sm" title="Ver"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('empleados.edit', $empleado->id) }}" class="btn btn-warning btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">No hay empleados registrados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
