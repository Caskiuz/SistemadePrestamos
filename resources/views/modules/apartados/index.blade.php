@extends('layouts.main')

@section('content')
<x-mobile-header title="Apartados" />

<x-horizontal-filters 
    :filters="[
        'vigente' => ['label' => 'Vigentes'],
        'vencido' => ['label' => 'Vencidos'],
        'completado' => ['label' => 'Completados']
    ]"
    :current-filter="request('status')"
    route="apartados.index"
    parameter="status" />

<div class="mobile-content">
    @if($apartados->isEmpty())
        <div class="empty-state">
            <i class="fa fa-bookmark"></i>
            <h4>No hay apartados registrados</h4>
            <p>Registra tu primer apartado</p>
            <a href="{{ route('apartados.create') }}" class="action-btn primary">
                <i class="fa fa-plus"></i>
                <span>Nuevo Apartado</span>
            </a>
        </div>
    @else
        <div class="list-mobile">
            @foreach($apartados as $apartado)
            <a href="{{ route('apartados.show', $apartado->id) }}" class="list-item">
                <div class="list-item-header">
                    <div>
                        <h4 class="list-item-title">{{ $apartado->cliente->nombre }}</h4>
                        <span class="list-item-subtitle">{{ $apartado->vencimiento }}</span>
                    </div>
                    <div class="status-badge status-{{ strtolower($apartado->estado) }}">
                        {{ $apartado->estado }}
                    </div>
                </div>
                
                <div class="info-card">
                    <div class="info-row">
                        <span class="label">Producto:</span>
                        <span class="value">{{ $apartado->producto->nombre }}</span>
                    </div>
                    <div class="info-row">
                        <span class="label">Anticipo:</span>
                        <span class="value money">{{ formatCurrency($apartado->anticipo) }}</span>
                    </div>
                </div>
                
                <div class="list-item-footer">
                    <i class="fa fa-calendar"></i>
                    <span>Vence: {{ $apartado->vencimiento }}</span>
                </div>
            </a>
            @endforeach
        </div>
    @endif
</div>
@endsection
