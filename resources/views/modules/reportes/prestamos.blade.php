@extends('layouts.main')

@section('content')
<x-mobile-header title="Préstamos Vigentes" backUrl="{{ route('reportes.index') }}" />

<x-horizontal-filters 
    :filters="[
        'vigentes' => ['label' => 'Vigentes'],
        'vencidos' => ['label' => 'Vencidos'],
        'expirados' => ['label' => 'Expirados'],
        'liquidados' => ['label' => 'Liquidados']
    ]"
    :current-filter="request('tipo')"
    route="reportes.prestamos.vigentes"
    parameter="tipo" />

<div class="mobile-content">
    @if($prestamos->isEmpty())
        <div class="empty-state">
            <i class="fa fa-money"></i>
            <h4>No hay préstamos {{ $tipo ?? 'vigentes' }}</h4>
            <p>No se encontraron préstamos en esta categoría</p>
        </div>
    @else
        <div class="list-mobile">
            @foreach($prestamos as $prestamo)
            <a href="{{ route('prestamos.show', $prestamo->id) }}" class="list-item">
                <div class="list-item-header">
                    <div>
                        <h4 class="list-item-title">{{ $prestamo->cliente->nombre ?? 'Sin cliente' }}</h4>
                        <span class="list-item-subtitle">{{ $prestamo->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="status-badge status-{{ $prestamo->estado }}">
                        {{ ucfirst($prestamo->estado) }}
                    </div>
                </div>
                
                <div class="info-card">
                    <div class="info-row">
                        <span class="label">Monto:</span>
                        <span class="value money">Bs. {{ number_format($prestamo->monto ?? 0, 2, ',', '.') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Pendiente:</span>
                        <span class="value pending">Bs. {{ number_format($prestamo->monto_pendiente ?? 0, 2, ',', '.') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Vencimiento:</span>
                        <span class="value">{{ $prestamo->fecha_vencimiento ? $prestamo->fecha_vencimiento->format('d/m/Y') : 'Sin fecha' }}</span>
                    </div>
                </div>
                
                <div class="list-item-footer">
                    <i class="fa fa-calendar"></i>
                    <span>{{ $prestamo->productos->count() }} prenda(s)</span>
                </div>
            </a>
            @endforeach
        </div>
        
        @if(method_exists($prestamos, 'hasPages') && $prestamos->hasPages())
        <div class="pagination-wrapper">
            {{ $prestamos->links() }}
        </div>
        @endif
    @endif
</div>
@endsection