@extends('layouts.app')

@section('content')
<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-12\">
            <div class=\"card\">
                <div class=\"card-header d-flex justify-content-between align-items-center\">
                    <h4>Notificaciones del Sistema</h4>
                    <button class=\"btn btn-primary\" onclick=\"marcarTodasLeidas()\">
                        <i class=\"fa fa-check\"></i> Marcar Todas como Leídas
                    </button>
                </div>
                <div class=\"card-body\">
                    @if($notificaciones->count() > 0)
                        <div class=\"table-responsive\">
                            <table class=\"table table-striped\">
                                <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Título</th>
                                        <th>Cliente</th>
                                        <th>Préstamo</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($notificaciones as $notificacion)
                                    <tr class=\"{{ !$notificacion->enviada ? 'table-warning' : '' }}\">\n                                        <td>\n                                            <span class=\"badge badge-{{ $notificacion->tipo == 'vencimiento' ? 'warning' : 'danger' }}\">\n                                                {{ ucfirst($notificacion->tipo) }}\n                                            </span>\n                                        </td>\n                                        <td>{{ $notificacion->titulo }}</td>\n                                        <td>{{ $notificacion->cliente->nombre }}</td>\n                                        <td>\n                                            <a href=\"{{ route('prestamos.show', $notificacion->prestamo->id) }}\">\n                                                {{ $notificacion->prestamo->folio }}\n                                            </a>\n                                        </td>\n                                        <td>{{ $notificacion->created_at->format('d/m/Y H:i') }}</td>\n                                        <td>\n                                            @if($notificacion->enviada)\n                                                <span class=\"badge badge-success\">Leída</span>\n                                            @else\n                                                <span class=\"badge badge-warning\">Pendiente</span>\n                                            @endif\n                                        </td>\n                                        <td>\n                                            @if(!$notificacion->enviada)\n                                                <button class=\"btn btn-sm btn-success\" onclick=\"marcarLeida({{ $notificacion->id }})\">\n                                                    <i class=\"fa fa-check\"></i>\n                                                </button>\n                                            @endif\n                                        </td>\n                                    </tr>\n                                    @endforeach\n                                </tbody>\n                            </table>\n                        </div>\n                        {{ $notificaciones->links() }}\n                    @else\n                        <div class=\"text-center py-4\">\n                            <i class=\"fa fa-bell-slash fa-3x text-muted mb-3\"></i>\n                            <h5>No hay notificaciones</h5>\n                        </div>\n                    @endif\n                </div>\n            </div>\n        </div>\n    </div>\n</div>\n\n<script>\nfunction marcarLeida(id) {\n    fetch(`/notificaciones/${id}/marcar-leida`, {\n        method: 'PATCH',\n        headers: {\n            'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').content\n        }\n    }).then(() => location.reload());\n}\n\nfunction marcarTodasLeidas() {\n    document.querySelectorAll('.table-warning button').forEach(btn => {\n        btn.click();\n    });\n}\n</script>\n@endsection