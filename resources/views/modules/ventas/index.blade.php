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
        <div class="save-buttons">
            <a href="{{ route('reportes.index') }}" class="btn btn-default btn-sm">Volver</a>
            <button class="btn btn-success btn-sm" onclick="window.print()">Imprimir</button>
        </div>
    </section>
    
    <section class="content">
        <table class="table table-striped card">
            <thead>
                <tr>
                    <th>Stock</th>
                    <th>Fecha de venta</th>
                    <th>Cliente</th>
                    <th>Prenda</th>
                    <th class="text-right">Precio de venta</th>
                </tr>
            </thead>
            <tbody>
                @php $totalVenta = 0; @endphp
                @forelse($ventas as $venta)
                    @php $totalVenta += $venta->monto; @endphp
                    <tr>
                        <td>{{ $venta->producto->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</td>
                        <td>{{ $venta->cliente->nombre }}</td>
                        <td>{{ $venta->producto->nombre }}</td>
                        <td class="text-right">${{ number_format($venta->monto, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay ventas registradas</td>
                    </tr>
                @endforelse
                <tr class="total">
                    <td>Totales</td>
                    <td colspan="3">{{ $ventas->count() }}</td>
                    <td class="text-right">${{ number_format($totalVenta, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </section>
</div>
@endsection
