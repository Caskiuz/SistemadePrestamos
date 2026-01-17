@extends('layouts.main')

@section('content')
<div class="cashflow-page">
    <header class="yp-header brown">
        <h1>
            <a href="{{ route('reportes.index') }}">
                <i class="fa fa-chevron-left"></i>
            </a>
            <span>{{ $titulo }}</span>
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
        @if($prestamos->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped card">
                    <thead>
                        <tr>
                            <th>Fecha de préstamo</th>
                            <th>Fecha de vencimiento</th>
                            <th>Contrato</th>
                            <th>Cliente</th>
                            <th>Prenda</th>
                            <th class="text-right">Monto del préstamo</th>
                            <th class="text-right">Abonado a capital</th>
                            <th class="text-right">Intereses pagados</th>
                            <th class="text-right">Recargos extemp. pagados</th>
                            <th class="text-right">Reemplazos de boleta</th>
                            <th class="text-right">Descuentos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalMonto = 0;
                            $totalAbonado = 0;
                            $totalIntereses = 0;
                        @endphp
                        @foreach($prestamos as $prestamo)
                            @php
                                $totalMonto += $prestamo->monto;
                                $totalAbonado += $prestamo->monto_pagado;
                                $totalIntereses += $prestamo->monto_total - $prestamo->monto;
                            @endphp
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($prestamo->fecha_prestamo)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($prestamo->fecha_vencimiento)->format('d/m/Y') }}</td>
                                <td>{{ $prestamo->folio }}</td>
                                <td>{{ $prestamo->cliente->nombre }}</td>
                                <td>
                                    @foreach($prestamo->productos as $producto)
                                        {{ $producto->nombre }}<br>
                                    @endforeach
                                </td>
                                <td class="text-right">${{ number_format($prestamo->monto, 2) }}</td>
                                <td class="text-right">${{ number_format($prestamo->monto_pagado, 2) }}</td>
                                <td class="text-right">${{ number_format($prestamo->monto_total - $prestamo->monto, 2) }}</td>
                                <td class="text-right">$0.00</td>
                                <td class="text-right">$0.00</td>
                                <td class="text-right">$0.00</td>
                            </tr>
                        @endforeach
                        <tr class="total">
                            <td colspan="2">Total</td>
                            <td colspan="3">{{ $prestamos->count() }}</td>
                            <td class="text-right">${{ number_format($totalMonto, 2) }}</td>
                            <td class="text-right">${{ number_format($totalAbonado, 2) }}</td>
                            <td class="text-right">${{ number_format($totalIntereses, 2) }}</td>
                            <td class="text-right">$0.00</td>
                            <td class="text-right">$0.00</td>
                            <td class="text-right">$0.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-info">
                No hay préstamos en esta categoría
            </div>
        @endif
    </section>
</div>
@endsection
