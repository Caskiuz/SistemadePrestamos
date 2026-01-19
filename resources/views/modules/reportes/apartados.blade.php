@extends('layouts.main')

@section('content')
<x-mobile-header title="{{ $titulo ?? 'Apartados' }}" backUrl="{{ route('reportes.index') }}" />

<div class="mobile-content">
    @if($apartados->isEmpty())
        <div class="empty-state">
            <i class="fa fa-shopping-cart"></i>
            <h4>No hay apartados</h4>
            <p>No se encontraron apartados en esta categoría</p>
        </div>
    @else
        <div class="list-mobile">
            @foreach($apartados as $apartado)
            <a href="{{ route('apartados.show', $apartado->id) }}" class="list-item">
                <div class="list-item-header">
                    <div>
                        <h4 class="list-item-title">{{ $apartado->cliente->nombre ?? 'Sin cliente' }}</h4>
                        <span class="list-item-subtitle">{{ $apartado->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="status-badge status-{{ strtolower($apartado->estado) }}">
                        {{ $apartado->estado }}
                    </div>
                </div>
                
                <div class="info-card">
                    <div class="info-row">
                        <span class="label">Producto:</span>
                        <span class="value">{{ $apartado->producto->nombre ?? 'Sin producto' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Monto:</span>
                        <span class="value money">Bs. {{ number_format($apartado->monto ?? 0, 2, ',', '.') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Vencimiento:</span>
                        <span class="value">{{ $apartado->fecha_vencimiento ? $apartado->fecha_vencimiento->format('d/m/Y') : 'Sin fecha' }}</span>
                    </div>
                </div>
                
                <div class="list-item-footer">
                    <i class="fa fa-calendar"></i>
                    <span>{{ $apartado->almacen->nombre ?? 'Sin almacén' }}</span>
                </div>
            </a>
            @endforeach
        </div>
        
        @if(method_exists($apartados, 'hasPages') && $apartados->hasPages())
        <div class="pagination-wrapper">
            {{ $apartados->links() }}
        </div>
        @endif
    @endif
</div>
@endsection