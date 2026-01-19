@extends('layouts.main')

@section('content')
<div class="cashflow-page">
    <header class="yp-header brown">
        <h1>
            <a href="{{ route('reportes.index') }}">
                <i class="fa fa-chevron-left"></i>
            </a>
            <span>Ventas</span>
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
            <a href="{{ route('ventas.create') }}" class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i> Nueva Venta
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
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th>Sucursal</th>
                        <th>Estado</th>
                        <th class="text-right">Precio Compra</th>
                        <th class="text-right">Precio Venta</th>
                        <th class="text-right">Ganancia</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $totalVenta = 0;
                        $totalCompra = 0;
                        $totalGanancia = 0;
                    @endphp
                    @forelse($ventas as $venta)
                        @php 
                            $precioCompra = $venta->producto->precio_compra ?? 0;
                            $ganancia = $venta->monto - $precioCompra;
                            $totalVenta += $venta->monto;
                            $totalCompra += $precioCompra;
                            $totalGanancia += $ganancia;
                        @endphp
                        <tr>
                            <td>{{ $venta->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</td>
                            <td>
                                <strong>{{ $venta->cliente->nombre }}</strong><br>
                                <small class="text-muted">{{ $venta->cliente->numero_documento }}</small>
                            </td>
                            <td>
                                <strong>{{ $venta->producto->nombre }}</strong><br>
                                <small class="text-muted">
                                    @if($venta->producto->marca)
                                        {{ $venta->producto->marca }}
                                        @if($venta->producto->modelo)
                                            - {{ $venta->producto->modelo }}
                                        @endif
                                    @endif
                                </small>
                            </td>
                            <td>{{ $venta->almacen->nombre ?? 'N/A' }}</td>
                            <td>
                                @if($venta->estado == 'COMPLETADA')
                                    <span class="badge badge-success">Completada</span>
                                @elseif($venta->estado == 'PENDIENTE')
                                    <span class="badge badge-warning">Pendiente</span>
                                @else
                                    <span class="badge badge-danger">Cancelada</span>
                                @endif
                            </td>
                            <td class="text-right">{{ formatCurrency($precioCompra) }}</td>
                            <td class="text-right">{{ formatCurrency($venta->monto) }}</td>
                            <td class="text-right">
                                <span class="{{ $ganancia >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ formatCurrency($ganancia) }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-info" onclick="verDetalles({{ $venta->id }})" title="Ver detalles">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    @if($venta->estado == 'PENDIENTE')
                                        <button class="btn btn-success" onclick="completarVenta({{ $venta->id }})" title="Completar">
                                            <i class="fa fa-check"></i>
                                        </button>
                                        <button class="btn btn-danger" onclick="cancelarVenta({{ $venta->id }})" title="Cancelar">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center">No hay ventas registradas</td>
                        </tr>
                    @endforelse
                    @if($ventas->count() > 0)
                    <tr class="total">
                        <td colspan="6"><strong>Totales ({{ $ventas->count() }} ventas)</strong></td>
                        <td class="text-right"><strong>{{ formatCurrency($totalCompra) }}</strong></td>
                        <td class="text-right"><strong>{{ formatCurrency($totalVenta) }}</strong></td>
                        <td class="text-right">
                            <strong class="{{ $totalGanancia >= 0 ? 'text-success' : 'text-danger' }}">
                                {{ formatCurrency($totalGanancia) }}
                            </strong>
                        </td>
                        <td></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </section>
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
    // Implementar vista de detalles
    console.log('Ver detalles de venta:', id);
}

function completarVenta(id) {
    if (confirm('¿Está seguro de completar esta venta?')) {
        // Implementar lógica para completar venta
        console.log('Completar venta:', id);
    }
}

function cancelarVenta(id) {
    if (confirm('¿Está seguro de cancelar esta venta?')) {
        // Implementar lógica para cancelar venta
        console.log('Cancelar venta:', id);
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
    
    // Opcional: recargar página con nuevos parámetros
    // window.location.href = url.toString();
});
</script>
@endsection
