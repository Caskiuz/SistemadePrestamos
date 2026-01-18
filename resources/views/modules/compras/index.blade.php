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
        <div class="save-buttons">
            <a href="{{ route('reportes.index') }}" class="btn btn-default btn-sm">Volver</a>
            <button class="btn btn-success btn-sm" onclick="window.print()">Imprimir</button>
        </div>
    </section>
    
    <section class="content">
        <div class="table-responsive">
            <table class="table table-striped card">
                <thead>
                    <tr>
                        <th>Stock</th>
                        <th>Fecha de compra</th>
                        <th>Dueño original</th>
                        <th>Prenda</th>
                        <th class="text-right">Precio de compra</th>
                        <th class="text-right">Precio de venta</th>
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
                            <td>{{ $compra->producto->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($compra->fecha_compra)->format('d/m/Y') }}</td>
                            <td>{{ $compra->cliente->nombre }}</td>
                            <td>{{ $compra->producto->nombre }}</td>
                            <td class="text-right">${{ number_format($compra->monto, 2) }}</td>
                            <td class="text-right">${{ number_format($compra->producto->precio_venta ?? 0, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay compras registradas</td>
                        </tr>
                    @endforelse
                    <tr class="total">
                        <td>Totales</td>
                        <td colspan="3">{{ $compras->count() }}</td>
                        <td class="text-right">${{ number_format($totalCompra, 2) }}</td>
                        <td class="text-right">${{ number_format($totalVenta, 2) }}</td>
                    </tr>
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
</style>
@endsection
