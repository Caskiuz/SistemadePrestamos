@extends('layouts.main')

@section('content')
<x-mobile-header title="Compras" backUrl="{{ route('reportes.index') }}" />

<x-horizontal-filters 
    :filters="[
        'completada' => ['label' => 'Completadas'],
        'pendiente' => ['label' => 'Pendientes'],
        'cancelada' => ['label' => 'Canceladas']
    ]"
    :current-filter="request('status')"
    route="compras.index"
    parameter="status" />

<div class="mobile-content">
    <x-search-box 
        placeholder="Buscar cliente o producto"
        route="compras.index"
        :value="request('q')" />
        
    <div class="card-mobile">
        <div class="section">
            <h3>Filtros</h3>
            <div class="form-group mb-3">
                <label>Desde</label>
                <input type="date" class="form-control" id="fecha_desde" value="{{ request('desde', now()->subMonth()->format('Y-m-d')) }}">
            </div>
            <div class="form-group mb-3">
                <label>Hasta</label>
                <input type="date" class="form-control" id="fecha_hasta" value="{{ request('hasta', now()->format('Y-m-d')) }}">
            </div>
        </div>
        
        <div class="action-grid">
            <a href="{{ route('compras.create') }}" class="btn-mobile primary">
                <i class="fa fa-plus"></i>
                <span>Nueva Compra</span>
            </a>
            <button class="btn-mobile secondary" onclick="window.print()">
                <i class="fa fa-print"></i>
                <span>Imprimir</span>
            </button>
        </div>
    </div>

    @if($compras->isEmpty())
        <div class="empty-state">
            <i class="fa fa-shopping-cart"></i>
            <h4>No hay compras registradas</h4>
            <p>Registra tu primera compra</p>
            <a href="{{ route('compras.create') }}" class="action-btn primary">
                <i class="fa fa-plus"></i>
                <span>Nueva Compra</span>
            </a>
        </div>
    @else
        <div class="list-mobile">
            @php
                $totalCompra = 0;
                $totalVenta = 0;
            @endphp
            @foreach($compras as $compra)
                @php
                    $totalCompra += $compra->monto;
                    $totalVenta += $compra->producto->precio_venta ?? 0;
                @endphp
                <div class="list-item">
                    <div class="list-item-header">
                        <div>
                            <h4 class="list-item-title">{{ $compra->cliente->nombre }}</h4>
                            <span class="list-item-subtitle">{{ \Carbon\Carbon::parse($compra->fecha_compra)->format('d/m/Y') }}</span>
                        </div>
                        <div class="status-badge status-{{ strtolower($compra->estado) }}">
                            {{ $compra->estado }}
                        </div>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-row">
                            <span class="label">Producto:</span>
                            <span class="value">{{ $compra->producto->nombre }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Tipo:</span>
                            <span class="value">{{ ucfirst(str_replace('_', ' ', $compra->tipo_compra ?? 'Adquisición')) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Precio Compra:</span>
                            <span class="value money">{{ formatCurrency($compra->monto) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Precio Venta:</span>
                            <span class="value">{{ formatCurrency($compra->producto->precio_venta ?? 0) }}</span>
                        </div>
                    </div>
                    
                    <div class="action-grid">
                        <a href="{{ route('compras.show', $compra->id) }}" class="btn-mobile secondary">
                            <i class="fa fa-eye"></i>
                            <span>Ver</span>
                        </a>
                        <a href="{{ route('compras.contrato', $compra->id) }}" class="btn-mobile danger" target="_blank">
                            <i class="fa fa-file-pdf"></i>
                            <span>PDF</span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        @if($compras->count() > 0)
        <div class="card-mobile">
            <div class="section">
                <h3>Totales ({{ $compras->count() }} compras)</h3>
                <div class="info-card">
                    <div class="info-row">
                        <span class="label">Total Compras:</span>
                        <span class="value money">{{ formatCurrency($totalCompra) }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Total Venta Estimada:</span>
                        <span class="value">{{ formatCurrency($totalVenta) }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif
</div>
@endsection
