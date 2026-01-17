@extends('layouts.main')
@section('contenido')
<div class="section-header bg-primary text-white rounded shadow-sm py-3 px-4 mb-4 align-items-center d-flex justify-content-between">
    <h1 class="mb-0" style="font-weight: 700; letter-spacing: 1px;"><i class="fas fa-clipboard-list mr-2"></i>Apartados</h1>
    <a href="{{ route('apartados.create') }}" class="btn btn-success btn-lg shadow-sm"><i class="fas fa-plus"></i> Nuevo Apartado</a>
</div>
<div class="section-body">
    <div class="card shadow-sm">
        <div class="card-header bg-light border-bottom-0">
            <h4 class="mb-0" style="font-size:21px; color:#151414"><i class="fas fa-list-alt mr-2"></i>Listado de Apartados</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered bg-white rounded shadow-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th>Cliente</th>
                            <th>Producto/Prenda</th>
                            <th>Anticipo</th>
                            <th>Vencimiento</th>
                            <th>Estado</th>
                            <th style="width:120px">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($apartados as $apartado)
                        <tr>
                            <td><span class="font-weight-bold">{{ $apartado->cliente->nombre }}</span></td>
                            <td>{{ $apartado->producto->nombre }}</td>
                            <td><span class="badge badge-info">${{ $apartado->anticipo }}</span></td>
                            <td>{{ $apartado->vencimiento }}</td>
                            <td>
                                <span class="badge {{ $apartado->estado == 'Vigente' ? 'badge-success' : 'badge-secondary' }}">{{ $apartado->estado }}</span>
                            </td>
                            <td>
                                <a href="{{ route('apartados.show', $apartado->id) }}" class="btn btn-info btn-sm" title="Ver"><i class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No hay apartados registrados.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
