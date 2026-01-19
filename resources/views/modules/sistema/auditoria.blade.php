@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Auditoría del Sistema</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Usuario</th>
                                    <th>Acción</th>
                                    <th>Módulo</th>
                                    <th>Detalles</th>
                                    <th>IP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($auditorias as $auditoria)
                                <tr>
                                    <td>{{ $auditoria->created_at->format('d/m/Y H:i:s') }}</td>
                                    <td>{{ $auditoria->usuario->nombre ?? 'Sistema' }}</td>
                                    <td>
                                        <span class="badge badge-info">{{ $auditoria->accion }}</span>
                                    </td>
                                    <td>{{ $auditoria->modulo }}</td>
                                    <td>{{ Str::limit($auditoria->detalles, 50) }}</td>
                                    <td>{{ $auditoria->ip }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">No hay registros de auditoría</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($auditorias->hasPages())
                        <div class="d-flex justify-content-center">
                            {{ $auditorias->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection