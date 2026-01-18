@extends('layouts.main')

@section('content')
<div class="main-content fade-in">
    <section class="section">
        <div class="section-header">
            <h1>Aprobaciones Pendientes</h1>
            <div class="section-header-breadcrumb">
                <span class="badge badge-warning badge-lg">{{ $aprobaciones->total() }} pendientes</span>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if($aprobaciones->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tipo</th>
                                            <th>Documento</th>
                                            <th>Solicitante</th>
                                            <th>Workflow</th>
                                            <th>Fecha Solicitud</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($aprobaciones as $aprobacion)
                                        <tr>
                                            <td>
                                                <span class="badge badge-info">
                                                    {{ ucfirst($aprobacion->tipo_documento) }}
                                                </span>
                                            </td>
                                            <td>#{{ $aprobacion->documento_id }}</td>
                                            <td>{{ $aprobacion->usuarioSolicitante->name }}</td>
                                            <td>{{ $aprobacion->workflow->nombre }}</td>
                                            <td>{{ $aprobacion->fecha_solicitud->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <span class="badge badge-{{ $aprobacion->estado == 'pendiente' ? 'warning' : ($aprobacion->estado == 'aprobado' ? 'success' : 'danger') }}">
                                                    {{ ucfirst($aprobacion->estado) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($aprobacion->estado == 'pendiente')
                                                    <button class="btn btn-sm btn-success" onclick="aprobar({{ $aprobacion->id }}, 'aprobar')">
                                                        <i class="fa fa-check"></i> Aprobar
                                                    </button>
                                                    <button class="btn btn-sm btn-danger" onclick="aprobar({{ $aprobacion->id }}, 'rechazar')">
                                                        <i class="fa fa-times"></i> Rechazar
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $aprobaciones->links() }}
                        @else
                            <div class="text-center py-4">
                                <i class="fa fa-tasks fa-3x text-muted mb-3"></i>
                                <h5>No hay aprobaciones pendientes</h5>
                                <p>Todas las solicitudes han sido procesadas</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Comentarios -->
<div class="modal fade" id="modalComentarios">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formAprobacion" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModal">Procesar Aprobación</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="accion" id="accionInput">
                    <div class="form-group">
                        <label>Comentarios</label>
                        <textarea name="comentarios" class="form-control" rows="3" placeholder="Ingrese sus comentarios..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn" id="btnConfirmar">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function aprobar(id, accion) {
    document.getElementById('formAprobacion').action = `/workflow/aprobaciones/${id}/procesar`;
    document.getElementById('accionInput').value = accion;
    document.getElementById('tituloModal').textContent = accion === 'aprobar' ? 'Aprobar Solicitud' : 'Rechazar Solicitud';
    document.getElementById('btnConfirmar').className = `btn ${accion === 'aprobar' ? 'btn-success' : 'btn-danger'}`;
    document.getElementById('btnConfirmar').textContent = accion === 'aprobar' ? 'Aprobar' : 'Rechazar';
    $('#modalComentarios').modal('show');
}
</script>
@endsection