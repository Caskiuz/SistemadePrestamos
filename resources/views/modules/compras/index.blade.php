@extends('layouts.main')

@section('content')
<div class="cashflow-page">
    <header class="yp-header brown">
        <h1>
            <a href="{{ route('reportes.index') }}">
                <i class="fa fa-chevron-left"></i>
            </a>
            <span>Compras</span>
        </h1>
        <h2>Matriz</h2>
    </header>
    
    <section class="toolbar">
        <div class="tool-group">
            <span class="group-name">Desde</span>
            <p class="input-group">
                <input type="date" class="form-control input-sm" id="fecha_desde" value="{{ request('desde', now()->subMonth()->format('Y-m-d')) }}">
            </p>
        </div>
        <div class="tool-group">
            <span class="group-name">Hasta</span>
            <p class="input-group">
                <input type="date" class="form-control input-sm" id="fecha_hasta" value="{{ request('hasta', now()->format('Y-m-d')) }}">
            </p>
        </div>
        <div class="tool-group">
            <span class="group-name">Buscar</span>
            <p class="input-group">
                <input type="text" class="form-control input-sm" id="buscar" placeholder="Cliente o producto..." value="{{ request('q') }}">
            </p>
        </div>
        <div class="save-buttons">
            <a href="{{ route('compras.create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> Nueva Compra
            </a>
            <a href="{{ route('reportes.index') }}" class="btn btn-default btn-sm">Volver</a>
            <button class="btn btn-success btn-sm" onclick="window.print()">Imprimir</button>
        </div>
    </section>
    
    <section class="content">
        <div class="table-responsive">
            <table class="table table-striped card">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Tipo Compra</th>
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Sucursal</th>
                        <th>Estado</th>
                        <th class="text-right">Precio Compra</th>
                        <th class="text-right">Precio Venta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalCompra = 0;
                        $totalVenta = 0;
                    @endphp
                    @forelse($compras as $compra)
                        @php
                            $totalCompra += $compra->monto;
                            $totalVenta += $compra->producto->precio_venta ?? 0;
                        @endphp
                        <tr>
                            <td>{{ $compra->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($compra->fecha_compra)->format('d/m/Y') }}</td>
                            <td>
                                @if($compra->tipo_compra == 'venta_directa')
                                    <span class="badge badge-primary">Venta Directa</span>
                                @elseif($compra->tipo_compra == 'liquidacion')
                                    <span class="badge badge-warning">Liquidación</span>
                                @else
                                    <span class="badge badge-info">Adquisición</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $compra->cliente->nombre }}</strong><br>
                                <small class="text-muted">{{ $compra->cliente->numero_documento }}</small>
                            </td>
                            <td>
                                <strong>{{ $compra->producto->nombre }}</strong><br>
                                <small class="text-muted">
                                    @if($compra->producto->marca)
                                        {{ $compra->producto->marca }}
                                        @if($compra->producto->modelo)
                                            - {{ $compra->producto->modelo }}
                                        @endif
                                    @endif
                                </small>
                            </td>
                            <td>
                                <span class="badge badge-secondary">{{ ucfirst(str_replace('_', ' ', $compra->producto->tipo)) }}</span>
                            </td>
                            <td>{{ $compra->almacen->nombre ?? 'N/A' }}</td>
                            <td>
                                @if($compra->estado == 'COMPLETADA')
                                    <span class="badge badge-success">Completada</span>
                                @elseif($compra->estado == 'PENDIENTE')
                                    <span class="badge badge-warning">Pendiente</span>
                                @else
                                    <span class="badge badge-danger">Cancelada</span>
                                @endif
                            </td>
                            <td class="text-right">{{ formatCurrency($compra->monto) }}</td>
                            <td class="text-right">{{ formatCurrency($compra->producto->precio_venta ?? 0) }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('compras.show', $compra->id) }}" class="btn btn-info" title="Ver detalles">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="{{ route('compras.contrato', $compra->id) }}" class="btn btn-danger" target="_blank" title="Generar Contrato">
                                        <i class="fa fa-file-pdf"></i>
                                    </a>
                                    @if($compra->estado == 'PENDIENTE')
                                        <button class="btn btn-success" onclick="completarCompra({{ $compra->id }})" title="Completar">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        <button class="btn btn-danger" onclick="cancelarCompra({{ $compra->id }})" title="Cancelar">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">No hay compras registradas</td>
                        </tr>
                    @endforelse
                    @if($compras->count() > 0)
                    <tr class="total">
                        <td colspan="7"><strong>Totales ({{ $compras->count() }} compras)</strong></td>
                        <td class="text-right"><strong>{{ formatCurrency($totalCompra) }}</strong></td>
                        <td class="text-right"><strong>{{ formatCurrency($totalVenta) }}</strong></td>
                        <td></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </section>
</div>

<!-- Modal para detalles -->
<div class="modal fade" id="modalDetalles" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles de la Compra</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="contenidoDetalles">
                <!-- Contenido cargado dinámicamente -->
            </div>
        </div>
    </div>
</div>

<style>
@media (max-width: 768px) {
    .toolbar {
        flex-direction: column;
        gap: 10px;
    }
    
    .tool-group {
        width: 100%;
    }
    
    .save-buttons {
        width: 100%;
        display: flex;
        gap: 10px;
    }
    
    .save-buttons .btn {
        flex: 1;
    }
    
    .table-responsive {
        font-size: 12px;
    }
    
    .table th,
    .table td {
        padding: 8px 4px;
        white-space: nowrap;
    }
    
    .yp-header h1 {
        font-size: 18px;
    }
    
    .yp-header h2 {
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .table {
        font-size: 11px;
    }
    
    .table th,
    .table td {
        padding: 6px 2px;
    }
    
    .toolbar {
        padding: 10px;
    }
}

.badge {
    font-size: 0.75em;
}

.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}
</style>

<script>
function verDetalles(id) {
    // Aquí puedes cargar los detalles vía AJAX
    $('#modalDetalles').modal('show');
    $('#contenidoDetalles').html('<p>Cargando detalles...</p>');
    
    // Ejemplo de carga de detalles (implementar según necesidades)
    setTimeout(() => {
        $('#contenidoDetalles').html('<p>Detalles de la compra #' + id + '</p>');
    }, 500);
}

function completarCompra(id) {
    if (confirm('¿Está seguro de completar esta compra?')) {
        // Implementar lógica para completar compra
        console.log('Completar compra:', id);
    }
}

function cancelarCompra(id) {
    if (confirm('¿Está seguro de cancelar esta compra?')) {
        // Implementar lógica para cancelar compra
        console.log('Cancelar compra:', id);
    }
}

// Filtros en tiempo real
$('#fecha_desde, #fecha_hasta, #buscar').on('change keyup', function() {
    var desde = $('#fecha_desde').val();
    var hasta = $('#fecha_hasta').val();
    var buscar = $('#buscar').val();
    
    var url = new URL(window.location.href);
    if (desde) url.searchParams.set('desde', desde);
    if (hasta) url.searchParams.set('hasta', hasta);
    if (buscar) url.searchParams.set('q', buscar);
    
    // Recargar página con nuevos parámetros (opcional)
    // window.location.href = url.toString();
});
</script>
@endsection
