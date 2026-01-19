@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Gestión de Subastas</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select class="form-control" id="filtroEstado">
                                <option value="">Todos los estados</option>
                                <option value="programada">Programadas</option>
                                <option value="activa">Activas</option>
                                <option value="finalizada">Finalizadas</option>
                                <option value="cancelada">Canceladas</option>
                            </select>
                        </div>
                    </div>

                    @if($subastas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Préstamo</th>
                                        <th>Cliente</th>
                                        <th>Precio Base</th>
                                        <th>Precio Actual</th>
                                        <th>Estado</th>
                                        <th>Fecha Fin</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subastas as $subasta)
                                    <tr>
                                        <td>{{ $subasta->codigo }}</td>
                                        <td>{{ $subasta->prestamo->folio }}</td>
                                        <td>{{ $subasta->prestamo->cliente->nombre }}</td>
                                        <td>{{ formatCurrency($subasta->precio_base) }}</td>
                                        <td>{{ formatCurrency($subasta->precio_actual) }}</td>
                                        <td>
                                            <span class="badge badge-{{ $subasta->estado == 'activa' ? 'success' : ($subasta->estado == 'finalizada' ? 'primary' : 'secondary') }}">
                                                {{ ucfirst($subasta->estado) }}
                                            </span>
                                        </td>
                                        <td>{{ $subasta->fecha_fin->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('subastas.show', $subasta->id) }}" class="btn btn-sm btn-info">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @if($subasta->estado == 'activa')
                                                <form method="POST" action="{{ route('subastas.finalizar', $subasta->id) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-warning">
                                                        <i class="fa fa-stop"></i> Finalizar
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $subastas->links() }}
                    @else
                        <div class="text-center py-4">
                            <i class="fa fa-gavel fa-3x text-muted mb-3"></i>
                            <h5>No hay subastas registradas</h5>
                            <p>Las subastas se crean automáticamente cuando un préstamo expira</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection